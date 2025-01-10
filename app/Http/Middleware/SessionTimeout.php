<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class SessionTimeout
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            $sessionTimeoutInMinutes = 100; // Set the desired session timeout in minutes
            $lastActivity = Session::get('last_activity');

            if ($lastActivity && Carbon::now()->diffInMinutes($lastActivity) >= $sessionTimeoutInMinutes) {
                // Session has expired, log the user out
                auth()->logout();
                Session::flush();
                return redirect('/login')->with('session_expired', 'Your session has expired.');
            }
        }

        Session::put('last_activity', Carbon::now());

        return $next($request);
    }
}
