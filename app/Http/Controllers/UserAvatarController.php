<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class UserAvatarController extends Controller
{
    public function show(User $user)
    {
        $avatarUrl = $user->getRemoteAvatarSource();

        if (!$avatarUrl) {
            abort(404);
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 Laravel Avatar Proxy',
                ])
                ->get($avatarUrl);
        } catch (ConnectionException $exception) {
            return redirect()->away($this->fallbackAvatarUrl($user));
        }

        if (!$response->successful()) {
            return redirect()->away($this->fallbackAvatarUrl($user));
        }

        return response($response->body(), 200, [
            'Content-Type' => $response->header('Content-Type', 'image/jpeg'),
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    private function fallbackAvatarUrl(User $user): string
    {
        $email = strtolower(trim((string) $user->email));
        $hash = md5($email);

        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }
}
