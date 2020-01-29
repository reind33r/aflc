<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

// use App\Model\Race\Race as RaceModel;

class RaceSubdomain
{
    public function handle($request, Closure $next)
    {
        $race = $request->route('race');

        View::share('race', $race);
        URL::defaults(['race' => $race->subdomain]);

        return $next($request);
    }
}