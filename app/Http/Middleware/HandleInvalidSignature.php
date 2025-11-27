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

            // If user is already verified, skip signature validation
            if ($user && $user->hasVerifiedEmail()) {
                return $next($request);
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
