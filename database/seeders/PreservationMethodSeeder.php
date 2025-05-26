<?php

namespace Database\Seeders;

use App\Models\PreservationMethod;
use Illuminate\Database\Seeder;

class PreservationMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        PreservationMethod::truncate();

        PreservationMethod::create([
            'name' => 'من سورة الفاتحة الى سورة الناس',
        ]);
        PreservationMethod::create([
            'name' => 'من سورة الناس الى سورة الفاتحة',
        ]);

    }
}
