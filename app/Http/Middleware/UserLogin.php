<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserLogin
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
        if (empty(Auth::guard('user')->check())) {
            return redirect(route('index.loginGet'));
        }else{
            $request->getUser = Auth::guard('user')->user();
        }
        return $next($request);
    }

}
