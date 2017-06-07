<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class HasCookieIdMiddleware
 *
 * @package App\Http\Middleware
 */
class HasCookieIdMiddleware
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
        if (! $request->headers->has('Cookie-Id') && empty($request->headers->get('Cookie-Id'))) {
            return response()->jsend(null, trans('api.cookie_header'), 412);
        }

        request()->cookie_id    = $request->headers->get('Cookie-Id');

        return $next($request);
    }
}
