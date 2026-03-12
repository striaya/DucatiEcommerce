<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreditSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('credit_applications')->insert([
            'order_id'            => 3,
            'user_id'             => 3,
            'provider'            => 'Adira Finance',
            'tenure_months'       => 36,
            'interest_rate_pct'   => 9.00,
            'dp_amount'           => 180000000,
            'loan_amount'         => 719000000,
            'monthly_installment' => 22844444,
            'total_payment'       => 822400000,
            'status'              => 'active',
            'doc_ktp_url'         => 'https://example.com/ktp-siti.jpg',
            'doc_slip_gaji_url'   => 'https://example.com/slip-siti.jpg',
            'submitted_at'        => Carbon::now()->subDays(44),
            'approved_at'         => Carbon::now()->subDays(42),
            'created_at'          => Carbon::now()->subDays(44),
            'updated_at'          => Carbon::now()->subDays(42),
        ]);

        for ($i = 1; $i <= 36; $i++) {
            $dueDate = Carbon::now()->subDays(44)->addMonths($i);
            $status  = $i <= 3 ? 'paid' : 'upcoming';
            $paidAt  = $i <= 3 ? Carbon::now()->subDays(44)->addMonths($i)->addDays(2) : null;

            DB::table('installment_schedules')->insert([
                'credit_id' => 1,
                'period_number'         => $i,
                'due_date'              => $dueDate->toDateString(),
                'amount_due'            => 22844444,
                'late_penalty'          => 0,
                'status'                => $status,
                'paid_at'               => $paidAt,
                'created_at'            => Carbon::now()->subDays(42),
                'updated_at'            => Carbon::now()->subDays(42),
            ]);
        }

        DB::table('credit_applications')->insert([
            'order_id'            => 5,
            'user_id'             => 5,
            'provider'            => 'FIF Group',
            'tenure_months'       => 24,
            'interest_rate_pct'   => 10.00,
            'dp_amount'           => 170000000,
            'loan_amount'         => 679000000,
            'monthly_installment' => 31246667,
            'total_payment'       => 749920000,
            'status'              => 'active',
            'doc_ktp_url'         => 'https://example.com/ktp-dewi.jpg',
            'doc_slip_gaji_url'   => null,
            'submitted_at'        => Carbon::now()->subDays(17),
            'approved_at'         => Carbon::now()->subDays(15),
            'created_at'          => Carbon::now()->subDays(17),
            'updated_at'          => Carbon::now()->subDays(15),
        ]);

        for ($i = 1; $i <= 24; $i++) {
            $dueDate = Carbon::now()->subDays(17)->addMonths($i);
            $status  = $i === 1 ? 'paid' : 'upcoming';
            $paidAt  = $i === 1 ? Carbon::now()->subDays(14) : null;

            DB::table('installment_schedules')->insert([
                'credit_id' => 2,
                'period_number'         => $i,
                'due_date'              => $dueDate->toDateString(),
                'amount_due'            => 31246667,
                'late_penalty'          => 0,
                'status'                => $status,
                'paid_at'               => $paidAt,
                'created_at'            => Carbon::now()->subDays(15),
                'updated_at'            => Carbon::now()->subDays(15),
            ]);
        }
    }
}