<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AutoLogoutSeller
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_seller) {
            if (Session::has('last_activity_time_seller')) {
                $inactivityTime = now()->diffInMinutes(Session::get('last_activity_time_seller'));

                if ($inactivityTime > 15) { // 15 minutes of inactivity
                    Auth::logout();
                    Session::forget('last_activity_time_seller');
                    return redirect('/login')->withErrors('Your session has expired due to inactivity.');
                }
            }

            Session::put('last_activity_time_seller', now());
        }

        return $next($request);
    }
}

