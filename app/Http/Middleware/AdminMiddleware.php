<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Log middleware entry
        \Log::info('AdminMiddleware triggered');

        // Check if the user is authenticated
        if (!auth()->check()) {
            \Log::info('User not authenticated');
            return redirect('/')->with('error', "Please Login First");
        }

        // Check if the user has the 'admin' role
        if (auth()->user()->role !== 'admin') {
            \Log::info('User is not an admin');
            return redirect('/')->with('error', "Your Unauthorized");
        }

        return $next($request);
    }
}
