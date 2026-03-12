<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('carts')->insert([
            [
                'user_id'    => 4,
                'product_id' => 8,
                'quantity'   => 1,
                'added_at'   => Carbon::now(),
            ],
            [
                'user_id'    => 4,
                'product_id' => 4,
                'quantity'   => 1,
                'added_at'   => Carbon::now(),
            ],
            [
                'user_id'    => 5,
                'product_id' => 1,
                'quantity'   => 1,
                'added_at'   => Carbon::now(),
            ],
        ]);
    }
}