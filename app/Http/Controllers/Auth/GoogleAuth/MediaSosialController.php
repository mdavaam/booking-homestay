<?php

namespace App\Http\Controllers\Auth\GoogleAuth;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MediaSosialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt('default_password'),
                'role' => session('google_action') === 'register' ? 'user' : 'user',
            ],
        );

        Auth::login($user);

        $redirectRoute = $user->role === 'admin' ? route('admin.dashboard') : route('home');

        return response()->view('auth.google-popup-close', compact('redirectRoute'));
    }
}
