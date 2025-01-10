<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AutoLogoutCustomer
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_customer) {
            if (Session::has('last_activity_time_customer')) {
                $inactivityTime = now()->diffInMinutes(Session::get('last_activity_time_customer'));

                if ($inactivityTime > 30) { // 30 minutes of inactivity
                    Auth::logout();
                    Session::forget('last_activity_time_customer');
                    return redirect('/login')->withErrors('Your session has expired due to inactivity.');
                }
            }

            Session::put('last_activity_time_customer', now());
        }

        return $next($request);
    }
}

