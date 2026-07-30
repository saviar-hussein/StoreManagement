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
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if the user is logged in AND if their role matches the required role
        if (!$request->user() || $request->user()->role !== $role) {
            
            // 2. If they don't match, INTERCEPT and return 403 Forbidden
            return response()->json([
                'success' => false,
                'message' => 'Forbidden. You do not have permission to access this resource.'
            ], 403);
        }

        // 3. If they DO match, pass the request to the Controller
        return $next($request);
    }
}