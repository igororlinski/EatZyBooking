<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    use SendsPasswordResetEmails, ResetsPasswords {
        ResetsPasswords::credentials insteadof SendsPasswordResetEmails;
        ResetsPasswords::broker insteadof SendsPasswordResetEmails;
    }

    protected $redirectTo = '/login';

    protected function credentials(Request $request)
    {
        if ($request->has('password')) {
            return $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            );
        }

        return $request->only('email');
    }

    public function showLinkRequestForm()
    {
        return view('auth.password.forgot');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.password.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        // $user->setRememberToken(Str::random(60)); // Skipped: Table lacks remember_token

        $user->save();

        event(new \Illuminate\Auth\Events\PasswordReset($user));
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return redirect('/login')->with('status', 'Your password has been reset! Please log in with your new password.');
    }
}
