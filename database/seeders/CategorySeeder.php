<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name'        => 'Superbike',
                'slug'        => 'superbike',
                'description' => 'Motor performa tinggi untuk penggemar kecepatan dan sirkuit',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'name'        => 'Naked',
                'slug'        => 'naked',
                'description' => 'Motor naked bertenaga tinggi dengan tampilan agresif',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'name'        => 'Adventure',
                'slug'        => 'adventure',
                'description' => 'Motor petualangan untuk segala medan dan perjalanan jauh',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'name'        => 'Scrambler',
                'slug'        => 'scrambler',
                'description' => 'Motor scrambler retro modern dengan karakter unik',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'name'        => 'Streetfighter',
                'slug'        => 'streetfighter',
                'description' => 'Motor streetfighter brutal dengan DNA balap',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'name'        => 'Diavel',
                'slug'        => 'diavel',
                'description' => 'Power cruiser Ducati dengan performa luar biasa',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ]);
    }
}
