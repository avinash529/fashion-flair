<x-guest-layout>
    <div class="auth-icon-header">
        <div class="auth-icon-circle">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="auth-heading">Verify Your Email</h2>
        <p class="auth-subtext" style="text-align:center;">Thanks for signing up! Please verify your email address by clicking the link we just sent you.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-status auth-status-success">
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="auth-submit" style="width:auto;padding:12px 28px;">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="auth-link" style="border:0;background:transparent;cursor:pointer;">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
