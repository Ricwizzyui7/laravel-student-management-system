<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Locale
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && in_array($request->user()->language, ['en', 'sw'])) {
            App::setLocale($request->user()->language);
        }

        return $next($request);
    }
}
