<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\ProfileSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Generate;

class CustomerController extends Controller
{
    public $status = [
        "1" => '<div class="badge badge-success badge-shadow">Active</div>',
        "2" => '<div class="badge badge-danger badge-shadow">De-Active</div>',
    ];

    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        // Get all users - for role 0, show only role 1 users
        $customers = User::select([
                'users.id',
                'users.name',
                'users.email',
                'users.role',
                'users.status',
                'users.created_at',
                'profile_setup.comapny_name as company_name',
                'profile_setup.wp_api_key as wp_api_key',
                DB::raw('(SELECT COUNT(*) FROM clients) as client_count'),
                DB::raw('(SELECT COUNT(*) FROM employees) as employee_count')
            ])
            ->leftJoin('profile_setup', 'profile_setup.id', '=', 'users.id')
            // If logged-in user has role 0, only show users with role 1
            ->when(Auth::user()->role == 0, function ($query) {
                return $query->where('users.role', 1);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('users.name', 'like', '%' . $search . '%')
                      ->orWhere('users.email', 'like', '%' . $search . '%')
                      ->orWhere('profile_setup.comapny_name', 'like', '%' . $search . '%');
                });
            })
            ->when($request->filter_role, function ($query, $role) {
                return $query->where('users.role', $role);
            })
            ->when($request->filter_status, function ($query, $status) {
                return $query->where('users.status', $status);
            })
            ->groupBy('users.id', 'users.name', 'users.email', 'users.role', 'users.status', 'users.created_at', 'profile_setup.comapny_name','profile_setup.wp_api_key')
            ->orderBy('users.id', 'DESC')
            ->paginate(10)
            ->withQueryString();
            $generate = Generate::find(1);
        // Decrypt allowed_users for each customer
        $code = Crypt::decrypt($generate->product_key);
        return view("customers.index", [
            'filters' => $request->all('search', 'filter_role', 'filter_status'),
            'search' => $request->search ?? '',
            'filter_role' => $request->filter_role ?? '',
            'filter_status' => $request->filter_status ?? '',
            'status' => $this->status,
            'code' => $code,
            'customers' => $customers,
        ]);
    }

    /**
     * Reset customer password to default 123456
     */
    public function resetPassword(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Set default password to 123456
            $defaultPassword = '123456';
            $user->password = Hash::make($defaultPassword);
            $user->save();

            // Log the action
            $action = "Password Reset to Default for User: " . $user->email . " by Super Admin";
            $log = app(\App\Http\Controllers\LogController::class);
            $log->SystemLog(Auth::user()->id, $action);

            return response()->json([
                'success' => true,
                'message' => 'Password reset to 123456 successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset password. Please try again.'
            ], 500);
        }
    }

    /**
     * Update customer status (activate/deactivate)
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = $request->status;
            $user->save();

            $statusText = $request->status == 1 ? 'Activated' : 'Deactivated';
            $action = "User Status Changed for: " . $user->email . " - Status: " . $statusText;
            $log = app(\App\Http\Controllers\LogController::class);
            $log->SystemLog(Auth::user()->id, $action);

            return response()->json([
                'success' => true,
                'message' => "User {$statusText} successfully."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status. Please try again.'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:1,2,3',
        ]);

        try {
            // Start database transaction
            \DB::beginTransaction();

            // Store plain password for email (before hashing)
            $plainPassword = $request->password;

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'status' => $request->status ?? 1,
            ]);

            // Send welcome email
            \Mail::to($user->email)->send(new \App\Mail\WelcomeCustomerMail($user, $plainPassword, null));

            // If email sending fails, it will throw an exception and rollback

            // Commit transaction
            \DB::commit();

            // Log the action
            $action = "New User Created: " . $user->email . " (Role: " . $request->role . ") by Super Admin";
            $log = app(\App\Http\Controllers\LogController::class);
            $log->SystemLog(Auth::user()->id, $action);

            return redirect()->route('customers.index')->with('success', 'User created successfully and welcome email sent.');
        } catch (\Exception $e) {
            // Rollback transaction on any error
            \DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create user or send email: ' . $e->getMessage());
        }
    }

    /**
     * Delete customer
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $email = $user->email;
            if(!$this->checkCustomerService($id)) return redirect()->back()->with('error', 'Customer has services. Please delete the services first.');
            $user->delete();

            $action = "User Deleted: " . $email . " by Super Admin";
            $log = app(\App\Http\Controllers\LogController::class);
            $log->SystemLog(Auth::user()->id, $action);

            return redirect()->back()->with('success', 'Customer deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete customer. Please try again.');
        }
    }
    public function checkCustomerService($customer_id)  {
        $count = Service::where('customer_id', $customer_id)->count();
        if($count > 0) return false;
        return true;
    }
}

