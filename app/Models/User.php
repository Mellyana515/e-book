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
}
