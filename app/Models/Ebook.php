<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'author',
        'price',
        'cover_image',
        'file_path',
        'category',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ebook) {
            if (empty($ebook->slug)) {
                $ebook->slug = Str::slug($ebook->title);
            }
        });
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function approvedPurchases()
    {
        return $this->hasMany(Purchase::class)->where('payment_status', 'approved');
    }

    public function isPurchasedBy(User $user): bool
    {
        return $this->approvedPurchases()->where('user_id', $user->id)->exists();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
