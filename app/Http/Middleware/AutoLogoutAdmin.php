<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AutoLogoutAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_admin) {
            if (Session::has('last_activity_time_admin')) {
                $inactivityTime = now()->diffInMinutes(Session::get('last_activity_time_admin'));

                if ($inactivityTime > 10) { // 10 minutes of inactivity
                    Auth::logout();
                    Session::forget('last_activity_time_admin');
                    return redirect('/login')->withErrors('Your session has expired due to inactivity.');
                }
            }

            Session::put('last_activity_time_admin', now());
        }

        return $next($request);
    }
}
