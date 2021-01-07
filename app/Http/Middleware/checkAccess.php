<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = false)
    {
        $user = Auth::user();
        if((!$role && $user) || $user->type == "admin" || $user->type == $role){ //Admin has access to all routes, but others have access only to their own routes
            return $next($request);
        }
        abort(403);
    }
}
