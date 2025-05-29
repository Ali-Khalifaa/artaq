<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        // Country::truncate();

        Country::create([
            'name' => 'السعودية',
            'phone_code'   => '+966',
            'alpha_code' =>'SA',
            'number_of_phone_digits' =>9,
            'status' => 1,
        ]);

    }
}
