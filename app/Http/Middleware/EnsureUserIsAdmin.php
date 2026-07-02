<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if the user is even logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Check if the user's role is exactly 'admin'
        // Using lowercase comparison 'admin' to prevent capitalization bugs
        if (Auth::user()->role && strtolower(Auth::user()->role) === 'admin') {
            return $next($request);
        }

        // 3. If they are logged in but NOT an admin (e.g., Staff), redirect them away safely
        return redirect('/students')->with('error', 'Unauthorized access! You must be a System Administrator to view that page.');
    }
}