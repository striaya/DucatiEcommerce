<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'full_name'    => 'Admin Ducati',
                'email'        => 'admin@ducati.com',
                'password_hash'=> Hash::make('admin123'),
                'phone'        => '081234567890',
                'nik'          => '3171000000000001',
                'role'         => 'admin',
                'kyc_status'   => 'verified',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'full_name'    => 'Budi Santoso',
                'email'        => 'budi@gmail.com',
                'password_hash'=> Hash::make('password123'),
                'phone'        => '081234567891',
                'nik'          => '3171000000000002',
                'role'         => 'customer',
                'kyc_status'   => 'verified',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'full_name'    => 'Siti Rahayu',
                'email'        => 'siti@gmail.com',
                'password_hash'=> Hash::make('password123'),
                'phone'        => '082345678901',
                'nik'          => '3171000000000003',
                'role'         => 'customer',
                'kyc_status'   => 'verified',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'full_name'    => 'Rizky Pratama',
                'email'        => 'rizky@gmail.com',
                'password_hash'=> Hash::make('password123'),
                'phone'        => '083456789012',
                'nik'          => '3171000000000004',
                'role'         => 'customer',
                'kyc_status'   => 'unverified',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'full_name'    => 'Dewi Kusuma',
                'email'        => 'dewi@gmail.com',
                'password_hash'=> Hash::make('password123'),
                'phone'        => '084567890123',
                'nik'          => '3171000000000005',
                'role'         => 'customer',
                'kyc_status'   => 'verified',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
        ]);
    }
}
