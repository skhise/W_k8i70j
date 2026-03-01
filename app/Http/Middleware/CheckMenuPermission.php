<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        $role = $user->role ?? 0;
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
                null, // Allow null route name (for root /)
            ];

            if (! in_array($currentRouteName, $allowedRoutes) && ! str_contains((string) $currentRouteName, 'generated')) {
                abort(403, 'Unauthorized access.');
            }
        }

        // Prevent non-super-admin roles from accessing customer routes
        if ($role != 0 && $currentRouteName && str_starts_with($currentRouteName, 'customers.')) {
            abort(403);
        }

        // Role 3 - Employee role restrictions (sub-admins get all menus)
        if ($role == 3) {
            
            $allowedMenus = auth()->user()->is_sub_admin ? config("roles.sub_admin") : config("roles.{$role}", []);
            
            if (! is_array($allowedMenus) || (! in_array($currentRouteName, $allowedMenus) && ! str_contains((string) $currentRouteName, 'generated'))) {
                abort(403);
            }
        }

        return $next($request);
    }
}

