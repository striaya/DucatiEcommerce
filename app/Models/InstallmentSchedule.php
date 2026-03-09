<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstallmentSchedule extends Model
{
    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'credit_id',
        'period_number',
        'due_date',
        'amount_due',
        'paid_amount',
        'paid_at',
        'status',
        'late_penalty',
    ];

    protected $casts = [
        'due_date'     => 'date',
        'amount_due'   => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'late_penalty' => 'decimal:2',
        'paid_at'      => 'datetime',
    ];

    public function creditApplication(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'credit_id', 'credit_id');
    }

    public function isLate(): bool
    {
        return $this->status === 'upcoming' && now()->isAfter($this->due_date);
    }

    public function markAsPaid(float $amount): void
    {
        $this->update([
            'paid_amount' => $amount,
            'paid_at'     => now(),
            'status'      => 'paid',
        ]);
    }
}