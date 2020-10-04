<?php

namespace App\Http\Middleware;

use Closure;

class AdminStaff
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
        if (auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3 || auth()->user()->role == 4)) {
            return $next($request);

        }
        return redirect(route('logout'));
        //return abort(401, 'Unauthorized');
    }
}
