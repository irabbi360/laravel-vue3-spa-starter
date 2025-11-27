<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Email already verified.'], Response::HTTP_OK);
            }
            return redirect()->intended($this->redirectTo);
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Email has been verified.'], Response::HTTP_OK);
        }

        return redirect()->intended($this->redirectTo.'?verified=1');
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Email already verified.'], Response::HTTP_OK);
            }
            return redirect()->intended($this->redirectTo);
        }

        $request->user()->sendEmailVerificationNotification();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Verification link sent to your email.'], Response::HTTP_OK);
        }

        return back()->with('resent', true);
    }
}
