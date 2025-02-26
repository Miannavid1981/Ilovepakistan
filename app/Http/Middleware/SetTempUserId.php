<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SetTempUserId
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('temp_user_id')) {
            $temp_user_id = bin2hex(random_bytes(10));
            session(['temp_user_id' => $temp_user_id ]);
        }

        return $next($request);
    }
}