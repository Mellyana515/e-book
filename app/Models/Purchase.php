<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ebook_id',
        'payment_proof',
        'payment_status',
        'amount',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }

    public function isApproved(): bool
    {
        return $this->payment_status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }
}
