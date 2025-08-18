<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // Mengirim email reset password
    public function kirimResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return back()->with('status', __($status));
    }

    public function create(Request $request, $token)
    {
        return view('email.reset-password-form', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:2|confirmed',
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user
                ->forceFill([
                    'password' => Hash::make($password),
                ])
                ->save();
        });

        return $status == Password::PASSWORD_RESET ? redirect()->route('welcome')->with('status', __($status)) : back()->withErrors(['email' => [__($status)]]);
    }
}
