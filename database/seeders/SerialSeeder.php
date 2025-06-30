<?php

namespace Database\Seeders;

use App\Models\Serial;
use Illuminate\Database\Seeder;

class SerialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        // Serial::truncate();

        Serial::create([
            'type' => 'Student',
            'prefix' => 'STU-',
            'start_number' => 1000,
        ]);

        Serial::create([
            'type' => 'Teacher',
            'prefix' => 'TEA-',
            'start_number' => 1000,
        ]);
        
        Serial::create([
            'type' => 'Admin',
            'prefix' => 'ADM-',
            'start_number' => 1000,
        ]);


    }
}
