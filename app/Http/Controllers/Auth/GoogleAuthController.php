<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (Throwable) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('Google sign-in is not configured yet.')]);
        }
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('Unable to authenticate with Google. Please try again.')]);
        }

        if (! $googleUser->getId() || ! $googleUser->getEmail()) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('Google did not return the account details needed to sign you in.')]);
        }

        $user = User::where('google_id', $googleUser->getId())->first()
            ?? User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $this->syncGoogleDetails($user, $googleUser);
        } else {
            $user = $this->createGoogleUser($googleUser);

            event(new Registered($user));
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    private function syncGoogleDetails(User $user, SocialiteUser $googleUser): void
    {
        $user->forceFill([
            'google_id' => $googleUser->getId(),
            'google_avatar' => $googleUser->getAvatar(),
            'email_verified_at' => $user->email_verified_at ?? now(),
        ])->save();
    }

    private function createGoogleUser(SocialiteUser $googleUser): User
    {
        $email = $googleUser->getEmail();

        return User::forceCreate([
            'name' => $googleUser->getName()
                ?: $googleUser->getNickname()
                ?: Str::before($email, '@'),
            'email' => $email,
            'google_id' => $googleUser->getId(),
            'google_avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(40)),
        ]);
    }
}
