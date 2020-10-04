<?php

namespace App\Http\Middleware;

use Closure;

class AdminManager
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
        if (auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 2 ) ) {
            return $next($request);
        }

        //return abort(401, 'Unauthorized');
        return redirect(route('logout'));
    }
}
