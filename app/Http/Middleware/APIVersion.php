<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APIVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {
        // if($guard == 'v1')
        // {
        //     return response()->json(['success'=>false,'message'=>'Please update app to get latest features.'], 301); // 301 Moved Permanently
        // }
        config(['app.api.version' => $guard]);
        return $next($request);
    }
}
