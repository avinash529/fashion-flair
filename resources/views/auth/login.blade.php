<x-guest-layout>
    <h2 class="auth-heading">Welcome Back</h2>
    <p class="auth-subtext">Sign in to your account to continue shopping.</p>

    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />

    <a href="{{ route('auth.google.redirect') }}" class="auth-social-button">
        <span class="auth-google-mark" aria-hidden="true">G</span>
        <span>{{ __('Continue with Google') }}</span>
    </a>

    <div class="auth-divider">{{ __('or sign in with email') }}</div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="auth-field">
            <x-input-label for="email" :value="__('Email Address')" />
            <div class="auth-input-group">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
                <svg class="auth-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="auth-field">
            <x-input-label for="password" :value="__('Password')" />
            <div class="auth-input-group">
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                <svg class="auth-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="auth-actions">
            <div class="auth-checkbox-row">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">{{ __('Remember me') }}</label>
            </div>

            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="auth-submit">{{ __('Sign In') }}</button>
    </form>

    <div class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}">Create one</a>
    </div>
</x-guest-layout>
