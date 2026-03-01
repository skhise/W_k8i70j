<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventSubAdminDelete
{
    /**
     * Handle an incoming request. Block sub-admins from any delete operation.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        if (! $user->is_sub_admin) {
            return $next($request);
        }
        if ($this->isDeleteOperation($request)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Delete operation is not allowed.'], 403);
            }

            return redirect()->back()
                ->with('error', 'Delete operation is not allowed.');
        }

        return $next($request);
    }

    /**
     * Determine if the request is a delete operation (DELETE method or delete route).
     */
    protected function isDeleteOperation(Request $request): bool
    {
        if ($request->isMethod('DELETE')) {
            return true;
        }

        $route = $request->route();
        if ($route && $route->getName() && str_contains(strtolower($route->getName()), 'delete')) {
            return true;
        }

        if (str_contains(strtolower($request->path()), 'delete')) {
            return true;
        }

        return false;
    }
}
