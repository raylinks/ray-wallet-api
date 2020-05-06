<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! Auth::user()->hasPermissionTo('Administer roles & permissions')) {
            abort(403, 'You do not have the required permission(s) to access this resource!');
        }

        return $next($request);
    }
}
