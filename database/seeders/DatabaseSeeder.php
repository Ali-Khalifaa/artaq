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
        $this->call(CitySeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(NationalitySeeder::class);
        $this->call(CircleTypeSeeder::class);
        $this->call(PreservationMethodSeeder::class);
        $this->call(TrackSeeder::class);
        $this->call(SerialSeeder::class);
    }
}
