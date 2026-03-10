<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserAddressSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user_addresses')->insert([
            [
                'user_id'        => 2, 
                'label'          => 'Rumah',
                'recipient_name' => 'Budi Santoso',
                'phone'          => '081234567891',
                'street'         => 'Jl. Sudirman No. 45, RT 003/RW 002, Kel. Karet',
                'city'           => 'Jakarta Selatan',
                'province'       => 'DKI Jakarta',
                'postal_code'    => '12920',
                'is_default'     => true,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'user_id'        => 2, 
                'label'          => 'Kantor',
                'recipient_name' => 'Budi Santoso',
                'phone'          => '081234567891',
                'street'         => 'Jl. Gatot Subroto Kav. 51, Kel. Kuningan Timur',
                'city'           => 'Jakarta Selatan',
                'province'       => 'DKI Jakarta',
                'postal_code'    => '12950',
                'is_default'     => false,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'user_id'        => 3,
                'label'          => 'Rumah',
                'recipient_name' => 'Siti Rahayu',
                'phone'          => '082345678901',
                'street'         => 'Jl. Pemuda No. 12, RT 001/RW 003, Kel. Rawamangun',
                'city'           => 'Jakarta Timur',
                'province'       => 'DKI Jakarta',
                'postal_code'    => '13220',
                'is_default'     => true,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'user_id'        => 4, 
                'label'          => 'Rumah',
                'recipient_name' => 'Rizky Pratama',
                'phone'          => '083456789012',
                'street'         => 'Jl. Diponegoro No. 88, Kel. Menteng',
                'city'           => 'Jakarta Pusat',
                'province'       => 'DKI Jakarta',
                'postal_code'    => '10310',
                'is_default'     => true,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'user_id'        => 5, 
                'label'          => 'Rumah',
                'recipient_name' => 'Dewi Kusuma',
                'phone'          => '084567890123',
                'street'         => 'Jl. Veteran No. 33, RT 002/RW 005, Kel. Gambir',
                'city'           => 'Jakarta Pusat',
                'province'       => 'DKI Jakarta',
                'postal_code'    => '10110',
                'is_default'     => true,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);
    }
}
