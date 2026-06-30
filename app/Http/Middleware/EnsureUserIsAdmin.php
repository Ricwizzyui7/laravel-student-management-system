<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is logged in, but their role is NOT admin, block them!
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action. Only system administrators can access this page.');
        }

        return $next($request);
    }
}
