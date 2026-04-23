<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Get Google OAuth URL for redirecting to Google
     */
    public function getGoogleAuthUrl()
    {
        try {
            $url = Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl();

            return response()->json([
                'success' => true,
                'redirect_url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate Google OAuth URL: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Google authentication failed: ' . $e->getMessage(),
            ], 401);
        }

        // Find or create user
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            // Link google_id if logging in via email match
            $user->update($this->googleProfileAttributes($googleUser, [
                'google_id' => $user->google_id ?: $googleUser->getId(),
                'name' => $googleUser->getName() ?: $user->name,
            ]));
        } else {
            // Create new user
            $user = User::create($this->googleProfileAttributes($googleUser, [
                'name'      => $googleUser->getName() ?: 'Pengguna Google',
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password'  => null,
                'role'      => 'user',
            ]));
        }

        // Login user
        Auth::login($user);
        $request->session()->regenerate();

        // Create Sanctum token for API usage
        $token = $user->createToken('google-auth')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully',
            'user' => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'role'       => $user->role,
                'avatar_url' => $user->avatar_url,
            ],
            'token' => $token,
            'redirect' => $user->isAdmin() ? '/admin/dashboard' : '/',
        ]);
    }

    /**
     * Get current authenticated user (for checking login status)
     */
    public function getCurrentUser(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Not authenticated',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'success' => true,
            'user' => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'role'       => $user->role,
                'avatar_url' => $user->avatar_url,
            ],
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    private function googleProfileAttributes(object $googleUser, array $attributes): array
    {
        if ($this->usersTableHasAvatarColumn()) {
            $attributes['avatar'] = $googleUser->getAvatar();
        }

        return $attributes;
    }

    private function usersTableHasAvatarColumn(): bool
    {
        static $hasAvatarColumn;

        return $hasAvatarColumn ??= Schema::hasColumn('users', 'avatar');
    }
}
