<?php

namespace Tests\Feature;

use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_redirected_to_two_factor_challenge_after_valid_credentials(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'password' => 'secret123',
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
            'role' => 'user',
        ]);

        $response->assertRedirect(route('two-factor.challenge'));
        $this->assertGuest();

        $user->refresh();

        $this->assertNotNull($user->two_factor_code);
        $this->assertNotNull($user->two_factor_expires_at);
        Mail::assertSent(TwoFactorCodeMail::class);
    }

    public function test_user_can_complete_login_with_valid_two_factor_code(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'password' => 'secret123',
            'role' => 'user',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
            'role' => 'user',
        ]);

        $user->refresh();

        $response = $this->post('/two-factor-challenge', [
            'code' => $user->two_factor_code,
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);

        $user->refresh();
        $this->assertNull($user->two_factor_code);
        $this->assertNull($user->two_factor_expires_at);
    }

    public function test_expired_two_factor_code_cannot_be_used(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'password' => 'secret123',
            'role' => 'user',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
            'role' => 'user',
        ]);

        $user->forceFill([
            'two_factor_expires_at' => now()->subMinute(),
        ])->save();

        $response = $this->from(route('two-factor.challenge'))->post('/two-factor-challenge', [
            'code' => $user->fresh()->two_factor_code,
        ]);

        $response->assertRedirect(route('two-factor.challenge'));
        $response->assertSessionHasErrors('code');
        $this->assertGuest();
    }

    public function test_admin_is_redirected_to_admin_dashboard_after_valid_two_factor_code(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'password' => 'secret123',
            'role' => 'admin',
        ]);

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'secret123',
            'role' => 'admin',
        ]);

        $admin->refresh();

        $response = $this->post('/two-factor-challenge', [
            'code' => $admin->two_factor_code,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_login_fails_when_role_selection_does_not_match_user_role(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'password' => 'secret123',
            'role' => 'user',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
            'role' => 'admin',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();

        $user->refresh();
        $this->assertNull($user->two_factor_code);
        Mail::assertNothingSent();
    }
}
