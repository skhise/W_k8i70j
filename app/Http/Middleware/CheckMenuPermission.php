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

        // Get allowed routes for the role from the config file

        $allowedMenus = config("roles.$role");
        // Get the current route name
        $currentRouteName = Route::currentRouteName();
        // dd($currentRouteName);

        // Check if the requested route name is in the allowed menus array

        if ($role == 3 && !in_array($currentRouteName, $allowedMenus) && !str_contains($currentRouteName, 'generated')) {
            // Optionally, you can redirect to a 403 page or home page
            abort(403);
        }

        return $next($request);
    }
}

