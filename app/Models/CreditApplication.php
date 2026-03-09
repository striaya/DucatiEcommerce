<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class CreditApplication extends Model
{
    protected $primaryKey = 'credit_id';

    protected $fillable = [
        'order_id',
        'user_id',
        'provider',
        'tenure_months',
        'interest_rate_pct',
        'dp_amount',
        'loan_amount',
        'monthly_installment',
        'total_payment',
        'status',
        'doc_ktp_url',
        'doc_slip_gaji_url',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'interest_rate_pct'   => 'decimal:2',
        'dp_amount'           => 'decimal:2',
        'loan_amount'         => 'decimal:2',
        'monthly_installment' => 'decimal:2',
        'total_payment'       => 'decimal:2',
        'submitted_at'        => 'datetime',
        'approved_at'         => 'datetime',
    ];


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function installmentSchedules(): HasMany
    {
        return $this->hasMany(InstallmentSchedule::class, 'credit_id', 'credit_id');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved' || $this->status === 'active';
    }

    public static function calculateInstallment(
        float $vehiclePrice,
        float $dpAmount,
        float $interestRatePct,
        int   $tenureMonths
    ): array {
        $loanAmount         = $vehiclePrice - $dpAmount;
        $totalInterest      = $loanAmount * ($interestRatePct / 100) * ($tenureMonths / 12);
        $totalPayment       = $loanAmount + $totalInterest;
        $monthlyInstallment = $totalPayment / $tenureMonths;

        return [
            'loan_amount'         => round($loanAmount, 2),
            'total_interest'      => round($totalInterest, 2),
            'total_payment'       => round($totalPayment, 2),
            'monthly_installment' => round($monthlyInstallment, 2),
        ];
    }

    public function generateSchedules(): void
    {
        $schedules = [];
        $dueDate   = now()->addMonth();

        for ($i = 1; $i <= $this->tenure_months; $i++) {
            $schedules[] = [
                'credit_id'     => $this->credit_id,
                'period_number' => $i,
                'due_date'      => $dueDate->copy()->format('Y-m-d'),
                'amount_due'    => $this->monthly_installment,
                'paid_amount'   => 0,
                'status'        => 'upcoming',
                'late_penalty'  => 0,
            ];
            $dueDate->addMonth();
        }

        InstallmentSchedule::insert($schedules);
    }
}
