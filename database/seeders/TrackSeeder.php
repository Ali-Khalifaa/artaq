<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        // CircleType::truncate();

        $now = now();
        $nationalities = [
            ['name' => 'الحر', 'created_at' => $now],
            ['name' => 'الحلقات', 'created_at' => $now],
            ['name' => 'المكثف', 'created_at' => $now],
        ];

        DB::table('tracks')->insert($nationalities);

    }
}
