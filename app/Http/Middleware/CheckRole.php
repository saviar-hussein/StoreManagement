<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //We need a Middleware to stop cashiers from accessing admin routes.
                // Check if user is logged in and has the correct role
        if (!$request->user() || $request->user()->role !== $role) {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }
        return $next($request);
    }
}
