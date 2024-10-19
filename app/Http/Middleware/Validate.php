<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use App\Models\Generate;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class Validate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Assume count is stored in the session
        $count = 0;//session('count', 0); // Default to 0 if not set
     
        $generate = Generate::find(1);
       
        $key = Crypt::decrypt($generate->product_key);
        $emp = Employee::count();
        if ($emp<$key) {
            return $next($request); // Replace with your desired route name
        } else {
            // Move to another route
            return redirect()->route('limit'); // Replace with your desired route name
        }

        // Call the next middleware (not reached due to redirect)
        
    }
}
