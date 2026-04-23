<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_expires_at' => 'datetime',
    ];

    protected $appends = [
        'avatar_url',
    ];

    public function isAdmin(): bool
    {
        return strtolower($this->role) === 'admin';
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function approvedPurchases()
    {
        return $this->hasMany(Purchase::class)->where('payment_status', 'approved');
    }

    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->avatar)) {
            if ($this->isRemoteAvatar($this->avatar) && $this->exists) {
                return route('users.avatar', $this);
            }

            return $this->avatar;
        }

        $email = strtolower(trim((string) $this->email));
        $hash = md5($email);

        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    public function getRemoteAvatarSource(): ?string
    {
        if (empty($this->avatar) || !$this->isRemoteAvatar($this->avatar)) {
            return null;
        }

        return preg_replace('/=s\d+-c$/', '=s256-c', $this->avatar) ?: $this->avatar;
    }

    private function isRemoteAvatar(string $value): bool
    {
        return str_starts_with($value, 'http://') || str_starts_with($value, 'https://');
    }
}
