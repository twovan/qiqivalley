<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->getUser = null;
        if (empty(Auth::guard('admin')->check())) {
            //return redirect(route('backend.loginGet'));//
            return redirect(route('backend.logout'));
        }else{
            $request->getUser = Auth::guard('admin')->user();
        }
        return $next($request);
    }

}
