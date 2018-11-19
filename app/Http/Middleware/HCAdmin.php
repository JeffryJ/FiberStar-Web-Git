<?php

namespace App\Http\Middleware;

use Closure;

class HCAdmin
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
        if($request->user()->role_id != IDofRole('HCD Admin') && $request->user()->role_id != IDofRole('Super Admin')){
            return back();
        }

        return $next($request);
    }
}
