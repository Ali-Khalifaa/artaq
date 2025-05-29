<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        // City::truncate();

        City::create([
            'name' => 'الرياض',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'جدة',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'الدمام',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'المدينة المنورة',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'الخبر',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'الطائف',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'القصيم',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'تبوك',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'حائل',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'عسير',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'جازان',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'الباحة',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'الحدود الشمالية',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'الجوف',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'نجران',
            'country_id' => 1,
        ]);
        City::create([
            'name' => 'الشرقية',
            'country_id' => 1,
        ]);

    }
}
