<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'order_id'   => 1,
                'method'     => 'va_bank',
                'gateway'    => 'Midtrans',
                'amount'     => 999000000,
                'status'     => 'success',
                'va_number'  => '8008001234567890',
                'paid_at'    => Carbon::now()->subDays(29),
                'expires_at' => Carbon::now()->subDays(28),
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(29),
            ],
            [
                'order_id'   => 2,
                'method'     => 'qris',
                'gateway'    => 'Midtrans',
                'amount'     => 385000000,
                'status'     => 'success',
                'va_number'  => null,
                'paid_at'    => Carbon::now()->subDays(9),
                'expires_at' => Carbon::now()->subDays(8),
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(9),
            ],
            [
                'order_id'   => 4,
                'method'     => 'va_bank',
                'gateway'    => 'Midtrans',
                'amount'     => 219000000,
                'status'     => 'pending',
                'va_number'  => '8008009876543210',
                'paid_at'    => null,
                'expires_at' => Carbon::now()->addDay(),
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
        ]);
    }
}
