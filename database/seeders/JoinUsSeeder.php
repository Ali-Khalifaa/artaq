<?php

namespace Database\Seeders;

use App\Models\JoinUs;
use Illuminate\Database\Seeder;

class JoinUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JoinUs::truncate();
        JoinUs::create([
            'facebook'=> '#',
            'twitter'=> '#',
            'instagram'=> '#',
            'linkedin'=> '#',
            'youtube'=> '#',
            'android_app_client'=> '#',
            'ios_app_client'=> '#',
            'android_app_teacher'=> '#',
            'ios_app_teacher'=> '#',
            'phone'=> '166633',
        ]);

    }
}
