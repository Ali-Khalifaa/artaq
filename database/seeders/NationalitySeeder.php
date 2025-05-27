<?php

namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Nationality::truncate();

        $now = now();
        $nationalities = [
            ['name' => 'مصري', 'created_at' => $now],
            ['name' => 'سعودي', 'created_at' => $now],
            ['name' => 'إماراتي', 'created_at' => $now],
            ['name' => 'كويتي', 'created_at' => $now],
            ['name' => 'قطري', 'created_at' => $now],
            ['name' => 'بحريني', 'created_at' => $now],
            ['name' => 'عماني', 'created_at' => $now],
            ['name' => 'أردني', 'created_at' => $now],
            ['name' => 'سوري', 'created_at' => $now],
            ['name' => 'لبناني', 'created_at' => $now],
            ['name' => 'فلسطيني', 'created_at' => $now],
            ['name' => 'عراقي', 'created_at' => $now],
            ['name' => 'ليبي', 'created_at' => $now],
            ['name' => 'تونسي', 'created_at' => $now],
            ['name' => 'جزائري', 'created_at' => $now],
            ['name' => 'مغربي', 'created_at' => $now],
            ['name' => 'يمني', 'created_at' => $now],
            ['name' => 'سوداني', 'created_at' => $now],
            ['name' => 'صومالي', 'created_at' => $now],
            ['name' => 'جيبوتي', 'created_at' => $now],
            ['name' => 'موريتاني', 'created_at' => $now],
        ];

        DB::table('nationalities')->insert($nationalities);

    }
}
