<?php

namespace Database\Seeders;

use Database\Seeders\Restaurant\RestKitchenSectionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(CreateAdminSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(JoinUsSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(PreservationMethodSeeder::class);
    }
}
