<?php

namespace App\Http\Middleware;

use Closure;

class DataAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->role_id != IDofRole('Data Management Admin') && $request->user()->role_id != IDofRole('Super Admin')){
            return back();
        }

        return $next($request);
    }
}
