<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        header('Access-Control-Allow-Origin: *');
        $headers = [
            'Access-Control-Allow-Methods'=> 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, Accept, Authorization, X-Request-With, X-Token-Auth,x-csrf-token'
        ];

        if ($request->getMethod() === "OPTIONS") {
            return response()->json('OK','200',$headers);
        }

        return $next($request)
        //->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')//;       
        ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization, X-Request-With, X-Token-Auth,x-csrf-token')
        ->header('Access-Control-Allow-Credentials', 'true');
    }
}
