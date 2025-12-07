<?php
namespace App\Http\Controllers;

use App\Models\Generate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfileSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = Auth::user();
        
        // For role 0 (Super Admin), show simplified profile
        if(Auth::user()->role == 0) {
            return view('profile.edit_super_admin', ["user" => $user]);
        }
        
        $profile = ProfileSetup::where(['id'=>1])->first();
        if(Auth::user()->role == 3){
            $profile = User::where(column: ['id'=>$user->id])->first();
        }
        
        // Get or create user-specific profile setup for Google Drive credentials
        $userProfileSetup = ProfileSetup::where('user_id', $user->id)->first();
        if (!$userProfileSetup) {
            // Don't create here, just return empty model for the view
            $userProfileSetup = new ProfileSetup();
            $userProfileSetup->user_id = $user->id;
        }
        
        $generate = Generate::find(1);
       
        $users = Crypt::decrypt($generate->product_key);
        // dd($profile['comapny_name']);
        return view('profile.edit', ["user" => $user,'profile'=>$profile,"users"=>$users, "userProfileSetup" => $userProfileSetup]);
    }
    public function limit(Request $request){
        return view('auth.limit');
    }
    public function update(Request $request)   {
        $user = Auth::user();
        // dd($request);
        $profile = ProfileSetup::where(['id'=> 1])->first();
        $profile->wp_user_name = $request->wp_user_name;
        $profile->wp_api_key = $request->wp_api_key;
        $profile->contact_number = $request->contact_number;
        $profile->address = $request->address;
       $save = $profile->save();
       if ($save) {
        return redirect()->route('profile.edit')->with('success','Changes Saved ');
       }
       return redirect()->route('profile.edit')->with('error','Failed, Try again');

    }

    /**
     * Update Google Drive credentials
     */
    public function updateGoogleDriveCredentials(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'google_client_id' => 'required|string',
            'google_client_secret' => 'required|string',
            'google_refresh_token' => 'required|string',
            'google_drive_folder_id' => 'nullable|string',
        ]);

        // Get or create user-specific profile setup
        $userProfileSetup = ProfileSetup::where('user_id', $user->id)->first();
        
        if (!$userProfileSetup) {
            // Create with default values for required fields
            $userProfileSetup = ProfileSetup::create([
                'user_id' => $user->id,
                'comapny_name' => $user->name ?? 'User Profile',
                'address' => '',
                'contact_number' => '',
                'wp_api_key' => '',
                'wp_user_name' => '',
                'company_email' => $user->email ?? '',
                'u_token' => '',
            ]);
        }

        $userProfileSetup->google_client_id = $request->google_client_id;
        $userProfileSetup->google_client_secret = $request->google_client_secret;
        $userProfileSetup->google_refresh_token = $request->google_refresh_token;
        $userProfileSetup->google_drive_folder_id = $request->google_drive_folder_id ?? null;
        
        $save = $userProfileSetup->save();
        
        if ($save) {
            return redirect()->route('profile.edit', ['tab' => 'google-drive'])->with('success', 'Google Drive credentials saved successfully');
        }
        
        return redirect()->route('profile.edit', ['tab' => 'google-drive'])->with('error', 'Failed to save Google Drive credentials. Please try again.');
    }
    public function change_password(Request $request) {
        $request->validate([
            'password' => 'required|min:6',
        ]);
        
        $user = Auth::user();
        $password = Hash::make($request->password);
        $user->password = $password;
        $changed = $user->save();
        
        if ($changed) {
            // Log the password change
            $action = "Password Changed for User: " . $user->email;
            $log = app(\App\Http\Controllers\LogController::class);
            $log->SystemLog($user->id, $action);
            
            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully.'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to change password. Please try again.'
        ]);
    }
    public function master_setup(Request $request)
    {
        $encrypted = "";
        if(isset($request->number)){
            
            $encrypted = Crypt::encrypt($request->number);
        }
        return view('setup.password-protected', ['encrypted' => $encrypted,"number"=>$request->number]);
    }
}
