<?php

namespace App\Http\Controllers;

use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    private const TWO_FACTOR_SESSION_KEY = 'auth.two_factor';

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('spa', [
            'initialPage' => 'login-page',
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
            'role'     => ['required', 'in:admin,user'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (
            $user
            && strtolower((string) $user->role) === $credentials['role']
            && Hash::check($credentials['password'], (string) $user->password)
        ) {
            return $this->startTwoFactorChallenge($request, $user, $request->boolean('remember'));
        }

        return back()
            ->withErrors(['email' => 'Email, password, atau role login tidak sesuai.'])
            ->onlyInput('email', 'role');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Welcome! Your account has been created.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget(self::TWO_FACTOR_SESSION_KEY);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out.');
    }

    public function showTwoFactorChallenge(Request $request)
    {
        $pending = $request->session()->get(self::TWO_FACTOR_SESSION_KEY);

        if (!$pending) {
            return redirect()->route('login');
        }

        $user = User::find($pending['user_id']);

        if (!$user) {
            $request->session()->forget(self::TWO_FACTOR_SESSION_KEY);

            return redirect()->route('login')->with('error', 'Sesi verifikasi tidak ditemukan. Silakan login kembali.');
        }

        return view('auth.two-factor-challenge', [
            'email' => $user->email,
        ]);
    }

    public function verifyTwoFactorChallenge(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $pending = $request->session()->get(self::TWO_FACTOR_SESSION_KEY);

        if (!$pending) {
            return redirect()->route('login')->with('error', 'Sesi verifikasi telah berakhir. Silakan login kembali.');
        }

        $user = User::find($pending['user_id']);

        if (!$user || !$user->two_factor_code || !$user->two_factor_expires_at) {
            $request->session()->forget(self::TWO_FACTOR_SESSION_KEY);

            return redirect()->route('login')->with('error', 'Kode verifikasi tidak tersedia. Silakan login kembali.');
        }

        if ($user->two_factor_expires_at->isPast()) {
            $user->forceFill([
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
            ])->save();

            return back()->withErrors([
                'code' => 'Kode verifikasi sudah kedaluwarsa. Silakan kirim ulang kode baru.',
            ]);
        }

        if (!hash_equals($user->two_factor_code, $data['code'])) {
            return back()->withErrors([
                'code' => 'Kode verifikasi tidak valid.',
            ])->onlyInput('code');
        }

        $remember = (bool) ($pending['remember'] ?? false);

        $user->forceFill([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ])->save();

        $request->session()->forget(self::TWO_FACTOR_SESSION_KEY);

        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->route($user->isAdmin() ? 'admin.dashboard' : 'home')
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    public function resendTwoFactorCode(Request $request)
    {
        $pending = $request->session()->get(self::TWO_FACTOR_SESSION_KEY);

        if (!$pending) {
            return redirect()->route('login')->with('error', 'Sesi verifikasi telah berakhir. Silakan login kembali.');
        }

        $user = User::find($pending['user_id']);

        if (!$user) {
            $request->session()->forget(self::TWO_FACTOR_SESSION_KEY);

            return redirect()->route('login')->with('error', 'Akun tidak ditemukan. Silakan login kembali.');
        }

        try {
            $this->issueTwoFactorCode($user);
        } catch (\Throwable $exception) {
            Log::error('Two-factor code resend failed: ' . $exception->getMessage(), [
                'user_id' => $user->id,
            ]);

            return back()->with('error', 'Kode verifikasi gagal dikirim ulang. Coba lagi sebentar lagi.');
        }

        return back()->with('info', 'Kode verifikasi baru sudah dikirim ke email Anda.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            Log::error('Google OAuth Error', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
            ]);
            return redirect()->route('login')->with('error', 'Google login failed. Please try again.');
        }

        try {
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                $user = User::where('email', $googleUser->getEmail())->first();
                if ($user) {
                    // Link google_id if logging in via email match
                    $user->update($this->googleProfileAttributes($googleUser, [
                        'google_id' => $googleUser->getId(),
                    ]));
                } else {
                    $user = User::create($this->googleProfileAttributes($googleUser, [
                        'name'      => $googleUser->getName() ?: 'Pengguna Google',
                        'email'     => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password'  => null,
                        'role'      => 'user',
                    ]));
                }
            } else {
                $user->update($this->googleProfileAttributes($googleUser, [
                    'name' => $googleUser->getName() ?: $user->name,
                ]));
            }

            return $this->startTwoFactorChallenge($request, $user, true);
        } catch (\Exception $e) {
            Log::error('User creation error', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
            ]);
            return redirect()->route('login')->with('error', 'Error creating user account. Please try again.');
        }
    }

    private function redirectByRole()
    {
        $user = Auth::user();
        if ($user && strtolower($user->role) === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    }

    private function startTwoFactorChallenge(Request $request, User $user, bool $remember)
    {
        try {
            $this->issueTwoFactorCode($user);
        } catch (\Throwable $exception) {
            Log::error('Two-factor code delivery failed: ' . $exception->getMessage(), [
                'user_id' => $user->id,
            ]);

            return redirect()->route('login')->withErrors([
                'email' => 'Kode OTP gagal dikirim ke email. Periksa konfigurasi SMTP/mail server Anda lalu coba lagi.',
            ])->withInput($request->only('email', 'role'));
        }

        $request->session()->put(self::TWO_FACTOR_SESSION_KEY, [
            'user_id' => $user->id,
            'remember' => $remember,
        ]);

        return redirect()->route('two-factor.challenge')
            ->with('info', 'Kami sudah mengirim kode verifikasi ke email Anda.');
    }

    private function issueTwoFactorCode(User $user): void
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->forceFill([
            'two_factor_code' => $code,
            'two_factor_expires_at' => Carbon::now()->addMinutes(10),
        ])->save();

        Mail::to($user->email)->send(new TwoFactorCodeMail($user, $code));
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
