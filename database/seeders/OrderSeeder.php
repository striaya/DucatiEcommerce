<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            'user_id'       => 2,
            'address_id'    => 1,
            'order_number'  => 'DCT-20250101-0001',
            'status'        => 'delivered',
            'purchase_type' => 'cash',
            'subtotal'      => 999000000,
            'grand_total'   => 999000000,
            'ordered_at'    => Carbon::now()->subDays(30),
            'created_at'    => Carbon::now()->subDays(30),
            'updated_at'    => Carbon::now()->subDays(25),
        ]);
        DB::table('order_items')->insert([
            'order_id'     => 1,
            'product_id'   => 1,
            'product_name' => 'Panigale V4 S',
            'quantity'     => 1,
            'unit_price'   => 999000000,
            'total_price'  => 999000000,
            'created_at'   => Carbon::now()->subDays(30),
            'updated_at'   => Carbon::now()->subDays(30),
        ]);

        DB::table('orders')->insert([
            'user_id'       => 2,
            'address_id'    => 1,
            'order_number'  => 'DCT-20250201-0002',
            'status'        => 'confirmed',
            'purchase_type' => 'cash',
            'subtotal'      => 385000000,
            'grand_total'   => 385000000,
            'ordered_at'    => Carbon::now()->subDays(10),
            'created_at'    => Carbon::now()->subDays(10),
            'updated_at'    => Carbon::now()->subDays(8),
        ]);
        DB::table('order_items')->insert([
            'order_id'     => 2,
            'product_id'   => 4,
            'product_name' => 'Monster SP',
            'quantity'     => 1,
            'unit_price'   => 385000000,
            'total_price'  => 385000000,
            'created_at'   => Carbon::now()->subDays(10),
            'updated_at'   => Carbon::now()->subDays(10),
        ]);

        DB::table('orders')->insert([
            'user_id'       => 3,
            'address_id'    => 3,
            'order_number'  => 'DCT-20250115-0003',
            'status'        => 'delivered',
            'purchase_type' => 'credit',
            'subtotal'      => 899000000,
            'grand_total'   => 899000000,
            'ordered_at'    => Carbon::now()->subDays(45),
            'created_at'    => Carbon::now()->subDays(45),
            'updated_at'    => Carbon::now()->subDays(40),
        ]);
        DB::table('order_items')->insert([
            'order_id'     => 3,
            'product_id'   => 6,
            'product_name' => 'Multistrada V4 S',
            'quantity'     => 1,
            'unit_price'   => 899000000,
            'total_price'  => 899000000,
            'created_at'   => Carbon::now()->subDays(45),
            'updated_at'   => Carbon::now()->subDays(45),
        ]);

        DB::table('orders')->insert([
            'user_id'       => 3,
            'address_id'    => 3,
            'order_number'  => 'DCT-20250301-0004',
            'status'        => 'pending',
            'purchase_type' => 'cash',
            'subtotal'      => 219000000,
            'grand_total'   => 219000000,
            'ordered_at'    => Carbon::now()->subDays(2),
            'created_at'    => Carbon::now()->subDays(2),
            'updated_at'    => Carbon::now()->subDays(2),
        ]);
        DB::table('order_items')->insert([
            'order_id'     => 4,
            'product_id'   => 8,
            'product_name' => 'Scrambler Icon',
            'quantity'     => 1,
            'unit_price'   => 219000000,
            'total_price'  => 219000000,
            'created_at'   => Carbon::now()->subDays(2),
            'updated_at'   => Carbon::now()->subDays(2),
        ]);

        DB::table('orders')->insert([
            'user_id'       => 5,
            'address_id'    => 5,
            'order_number'  => 'DCT-20250220-0005',
            'status'        => 'shipped',
            'purchase_type' => 'credit',
            'subtotal'      => 849000000,
            'grand_total'   => 849000000,
            'ordered_at'    => Carbon::now()->subDays(18),
            'created_at'    => Carbon::now()->subDays(18),
            'updated_at'    => Carbon::now()->subDays(15),
        ]);
        DB::table('order_items')->insert([
            'order_id'     => 5,
            'product_id'   => 10,
            'product_name' => 'Streetfighter V4 S',
            'quantity'     => 1,
            'unit_price'   => 849000000,
            'total_price'  => 849000000,
            'created_at'   => Carbon::now()->subDays(18),
            'updated_at'   => Carbon::now()->subDays(18),
        ]);
    }
}
