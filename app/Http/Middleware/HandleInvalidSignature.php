<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

class HandleInvalidSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Get user ID from route parameter
            $userId = $request->route('id');
            $user = \App\Models\User::find($userId);

            // Check if user exists
            if (!$user) {
                return response()->json([
                    'message' => 'User not found.',
                ], 404);
            }

            // Check if authenticated user matches the user being verified
            if ($request->user() && $request->user()->id != $userId) {
                return response()->json([
                    'message' => 'Unauthorized. You can only verify your own email.',
                ], 403);
            }

            // If user is already verified, skip signature validation
            if ($user->hasVerifiedEmail()) {
                return response()->json([
                    'message' => 'Email already verified.',
                ], 200);
            }

            // Check if signature is valid
            if (!$request->hasValidSignature()) {
                return response()->json([
                    'message' => 'Invalid or expired verification link.',
                ], 400);
            }
            
            return $next($request);
        } catch (InvalidSignatureException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Invalid or expired verification link.',
                ], 400);
            }
            throw $e;
        }
    }
}
