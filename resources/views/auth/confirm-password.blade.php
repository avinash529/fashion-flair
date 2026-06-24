<x-guest-layout>
    <div class="auth-icon-header">
        <div class="auth-icon-circle">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <h2 class="auth-heading">Confirm Password</h2>
        <p class="auth-subtext" style="text-align:center;">This is a secure area. Please confirm your password before continuing.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

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

        <!-- Submit -->
        <button type="submit" class="auth-submit">{{ __('Confirm') }}</button>
    </form>
</x-guest-layout>
