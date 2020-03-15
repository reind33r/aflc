<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class UseOrganizerGuard
{
    public function handle($request, Closure $next)
    {
        Auth::shouldUse('web:organizers');

        return $next($request);
    }
}