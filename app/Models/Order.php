<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{

    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'purchase_type',
        'status',
        'subtotal',
        'grand_total',
        'ordered_at',
    ];

    protected $casts = [
        'subtotal'    => 'decimal:2',
        'grand_total' => 'decimal:2',
        'ordered_at'  => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function creditApplication(): HasOne
    {
        return $this->hasOne(CreditApplication::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function isCredit(): bool
    {
        return $this->purchase_type === 'credit';
    }

    public function isPaid(): bool
    {
        return $this->payments()->where('status', 'success')->exists();
    }

    public static function generateOrderNumber(): string
    {
        $date   = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return "DCT-{$date}-{$random}";
    }
}
