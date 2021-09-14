<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfJsonPayload
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
        // Return JSON invalid error if Content-Type not JSON. To prevent SQL errors.
        if(!$request->all()){
            return response()->json([
                'error' => 'The request is not a valid JSON',
            ], 400);
        }
        return $next($request);
    }
}
