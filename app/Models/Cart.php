<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $primaryKey = 'cart_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'added_at',
    ];

    protected $casts = [
        'added_at' => 'datetime',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }


    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->product->price;
    }
}