<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Locale
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
        if($request->segment(1) == config('app.fallback_locale'))
        {
            $url = str_replace('/'.$request->segment(1), '', $request->url());

            return redirect($url, 301);
        }
        return $next($request);
    }
}
