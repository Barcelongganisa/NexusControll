<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubPcSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sub_pcs')->insert([
            ['ip_address' => '192.168.1.19', 'vnc_port' => 6081],
            ['ip_address' => '192.168.1.18', 'vnc_port' => 6080],
            ['ip_address' => '192.168.1.103', 'vnc_port' => 6082],
        ]);
    }
}

