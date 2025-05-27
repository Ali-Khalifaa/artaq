<?php

namespace Database\Seeders;

use App\Models\CircleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CircleTypeSeeder extends Seeder
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
            ['name' => 'المكثف بنين', 'created_at' => $now],
            ['name' => 'المكثف بنات', 'created_at' => $now],
        ];

        DB::table('circle_types')->insert($nationalities);

    }
}
