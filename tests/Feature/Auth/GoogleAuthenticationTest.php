<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_redirected_to_google(): void
    {
        Socialite::fake('google');

        $response = $this->get(route('auth.google.redirect'));

        $response->assertRedirect('https://socialite.fake/google/authorize');
    }

    public function test_user_can_register_with_google(): void
    {
        Socialite::fake('google', SocialiteUser::fake([
            'id' => 'google-123',
            'name' => 'Google User',
            'email' => 'google@example.com',
            'avatar' => 'https://example.com/google-user.jpg',
        ]));

        $response = $this->get(route('auth.google.callback'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Google User',
            'email' => 'google@example.com',
            'google_id' => 'google-123',
            'google_avatar' => 'https://example.com/google-user.jpg',
        ]);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_existing_user_can_login_with_google_by_email(): void
    {
        $user = User::factory()->create([
            'email' => 'existing@example.com',
            'google_id' => null,
        ]);

        Socialite::fake('google', SocialiteUser::fake([
            'id' => 'existing-google-123',
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'avatar' => 'https://example.com/existing-user.jpg',
        ]));

        $response = $this->get(route('auth.google.callback'));

        $this->assertAuthenticatedAs($user->fresh());
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'existing@example.com',
            'google_id' => 'existing-google-123',
        ]);
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
