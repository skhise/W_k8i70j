<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckMenuPermission
{
    public function handle($request, Closure $next)
    {
        // Get the user's role
        $role = Auth::user()->role ?? 0; // Assuming you have a 'role' field on your User model

        // Get the current route name
        $currentRouteName = Route::currentRouteName();

        // Role 0 (Super Admin) - Only allow customer-related routes
        if ($role == 0) {
            $allowedRoutes = [
                'customers.index',
                'customers.create',
                'customers.store',
                'customers.resetPassword',
                'customers.updateStatus',
                'customers.destroy',
                'profile.edit',
                'profile.update',
                'profile.change-password',
                'profile.destroy',
                'logout',
                null // Allow null route name (for root /)
            ];
            
            if (!in_array($currentRouteName, $allowedRoutes) && !str_contains($currentRouteName, 'generated')) {
                abort(403, 'Unauthorized access.');
            }
        }

        // Prevent non-super-admin roles from accessing customer routes
        if ($role != 0 && $currentRouteName && str_starts_with($currentRouteName, 'customers.')) {
            abort(403);
        }

        // Role 3 - Employee role restrictions
        if ($role == 3) {
            $allowedMenus = config("roles.$role");
            if (!in_array($currentRouteName, $allowedMenus) && !str_contains($currentRouteName, 'generated')) {
                abort(403);
            }
        }

        return $next($request);
    }
}

