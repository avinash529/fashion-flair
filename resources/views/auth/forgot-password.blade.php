<x-guest-layout>
    <div class="auth-icon-header">
        <div class="auth-icon-circle">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>
        <h2 class="auth-heading">Forgot Password?</h2>
        <p class="auth-subtext" style="text-align:center;">No worries — enter your email and we'll send you a reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="auth-field">
            <x-input-label for="email" :value="__('Email Address')" />
            <div class="auth-input-group">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                <svg class="auth-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Submit -->
        <button type="submit" class="auth-submit">{{ __('Send Reset Link') }}</button>
    </form>

    <div class="auth-footer">
        Remember your password? <a href="{{ route('login') }}">Sign in</a>
    </div>
</x-guest-layout>
