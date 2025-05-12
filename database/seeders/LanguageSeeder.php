<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Language::truncate();

        $language = Language::create([
            'code'   => 'en',
            'status' => 1,
        ]);

        $language->setTranslations([
            'ar' => [
                'title'       => 'إنجليزي',
                'description' => 'إنجليزي',
            ],
            'en' => [
                'title'       => 'English',
                'description' => 'English',
            ],
            'fr' => [
                'title'       => 'Anglais',
                'description' => 'Anglais',
            ],
            'hi' => [
                'title'       => 'अंग्रेज़ी',
                'description' => 'अंग्रेज़ी',
            ],
            'ms' => [
                'title'       => 'Inggeris',
                'description' => 'Inggeris',
            ],
            'ur' => [
                'title'       => 'انگلش',
                'description' => 'انگلش',
            ],
            'zh' => [
                'title'       => '英语',
                'description' => '英语',
            ],
        ]);

        $language = Language::create([
            'code'   => 'ar',
            'status' => 1,
        ]);

        $language->setTranslations([
            'ar' => [
                'title'       => 'العربية',
                'description' => 'العربية',
            ],
            'en' => [
                'title'       => 'Arabic',
                'description' => 'Arabic',
            ],
            'fr' => [
                'title'       => 'Arabe',
                'description' => 'Arabe',
            ],
            'hi' => [
                'title'       => 'अरबी',
                'description' => 'अरबी',
            ],
            'ms' => [
                'title'       => 'Arab',
                'description' => 'Arab',
            ],
            'ur' => [
                'title'       => 'عربی',
                'description' => 'عربی',
            ],
            'zh' => [
                'title'       => '阿拉伯语',
                'description' => '阿拉伯语',
            ],
        ]);
    }
}
