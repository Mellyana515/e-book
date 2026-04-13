<?php

namespace Tests\Feature;

use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_callback_redirects_regular_user_to_two_factor_challenge(): void
    {
        Mail::fake();

        $socialiteUser = Mockery::mock(SocialiteUser::class);
        $socialiteUser->shouldReceive('getId')->andReturn('google-user-1');
        $socialiteUser->shouldReceive('getEmail')->andReturn('user@gmail.com');
        $socialiteUser->shouldReceive('getName')->andReturn('Google User');

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('stateless')->andReturnSelf();
        $provider->shouldReceive('user')->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('two-factor.challenge'));
        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'email' => 'user@gmail.com',
            'role' => 'user',
            'google_id' => 'google-user-1',
        ]);

        $user = User::where('email', 'user@gmail.com')->first();

        $this->assertNotNull($user?->two_factor_code);
        $this->assertNotNull($user?->two_factor_expires_at);
        Mail::assertSent(TwoFactorCodeMail::class);
    }

    public function test_google_callback_redirects_admin_to_two_factor_challenge_before_dashboard(): void
    {
        Mail::fake();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'google_id' => 'google-admin-1',
        ]);

        $socialiteUser = Mockery::mock(SocialiteUser::class);
        $socialiteUser->shouldReceive('getId')->andReturn('google-admin-1');
        $socialiteUser->shouldReceive('getEmail')->andReturn('admin@gmail.com');
        $socialiteUser->shouldReceive('getName')->andReturn('Admin');

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('stateless')->andReturnSelf();
        $provider->shouldReceive('user')->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('two-factor.challenge'));
        $this->assertGuest();
        Mail::assertSent(TwoFactorCodeMail::class);
    }
}
