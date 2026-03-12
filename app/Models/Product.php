<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image_url',
        'engine_cc',
        'power_hp',
        'credit_eligible',
        'is_active',
    ];

    protected $casts = [
        'price'           => 'decimal:2',
        'power_hp'        => 'decimal:1',
        'credit_eligible' => 'boolean',
        'is_active'       => 'boolean',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCreditEligible($query)
    {
        return $query->where('credit_eligible', true);
    }


    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}
