<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StoreLastVisitedPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentUrl = $request->fullUrl();
        if (strpos($currentUrl, 'register') === false && strpos($currentUrl, 'login') === false) {
            // Store the URL in the session
            Session::put('last_visited_url', $currentUrl);
            // dd($currentUrl);
        }

        return $next($request);
        
    }
}
