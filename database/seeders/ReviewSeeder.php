<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'user_id'     => 2,
                'product_id'  => 1,
                'order_id'    => 1,
                'rating'      => 5,
                'title'       => 'Motor terbaik yang pernah saya miliki',
                'body'        => 'Panigale V4 S benar-benar luar biasa. Akselerasinya gila-gilaan, handling sangat presisi di tikungan. Elektroniknya membantu sekali untuk kontrol traksi. Worth every penny! Ducati memang tidak ada tandingannya untuk superbike.',
                'is_verified' => true,
                'created_at'  => Carbon::now()->subDays(20),
                'updated_at'  => Carbon::now()->subDays(20),
            ],

            [
                'user_id'     => 3,
                'product_id'  => 6,
                'order_id'    => 3,
                'rating'      => 5,
                'title'       => 'Motor touring paling sempurna',
                'body'        => 'Multistrada V4 S adalah motor yang saya impikan sejak lama. Sistem radar-nya benar-benar membantu saat touring jarak jauh. Suspensi semi-aktifnya luar biasa nyaman namun tetap sporty. Teknologi cruise control adaptif-nya sungguh canggih.',
                'is_verified' => true,
                'created_at'  => Carbon::now()->subDays(35),
                'updated_at'  => Carbon::now()->subDays(35),
            ],

            [
                'user_id'     => 2,
                'product_id'  => 8,
                'order_id'    => null,
                'rating'      => 4,
                'title'       => 'Scrambler yang menyenangkan untuk harian',
                'body'        => 'Scrambler Icon sangat fun dikendarai sehari-hari. Mesinnya responsif, tidak terlalu berat, dan desainnya retro yang selalu mendapat pujian di jalan. Kurang satu bintang karena tidak ada riding mode selain satu mode standar.',
                'is_verified' => false,
                'created_at'  => Carbon::now()->subDays(5),
                'updated_at'  => Carbon::now()->subDays(5),
            ],
            [
                'user_id'     => 3,
                'product_id'  => 4,
                'order_id'    => null,
                'rating'      => 5,
                'title'       => 'Monster yang sesungguhnya',
                'body'        => 'Monster SP jauh lebih baik dari Monster generasi sebelumnya. Ringan, bertenaga, dan handling yang sangat intuitif. Suspensi Ohlins-nya sangat worth it. Motor naked terbaik di segmennya menurut saya.',
                'is_verified' => false,
                'created_at'  => Carbon::now()->subDays(8),
                'updated_at'  => Carbon::now()->subDays(8),
            ],
            [
                'user_id'     => 5,
                'product_id'  => 10,
                'order_id'    => null,
                'rating'      => 5,
                'title'       => 'Brutally beautiful',
                'body'        => 'Streetfighter V4 S adalah motor yang membuat semua orang berhenti dan menatap. Powernya mengerikan tapi elektroniknya membuatnya tetap terkontrol. Wing aerodinamis yang bukan sekadar gaya — benar-benar memberikan downforce nyata.',
                'is_verified' => false,
                'created_at'  => Carbon::now()->subDays(3),
                'updated_at'  => Carbon::now()->subDays(3),
            ],
        ]);
    }
}
