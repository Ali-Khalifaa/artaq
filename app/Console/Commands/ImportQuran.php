<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Surah;
use App\Models\Ayah;

class ImportQuran extends Command
{
    protected $signature = 'import:quran';
    protected $description = 'Fetch Quran from API and store into database';

    public function handle()
    {
        $this->info('Fetching Quran data...');

        Surah::truncate();
        Ayah::truncate();

        $response = Http::timeout(600)->get('https://api.alquran.cloud/v1/quran');

        if ($response->failed()) {
            $this->error('Failed to fetch Quran data.');
            return 1;
        }

        $data = $response->json()['data']['surahs'];

        foreach ($data as $surah) {
            $this->info("Importing Surah: {$surah['englishName']}");

            $surahModel = Surah::updateOrCreate(
                ['number' => $surah['number']],
                [
                    'name' => $surah['name'],
                    'normalized_name' => $this->normalizeArabic($surah['name']),
                    'english_name' => $surah['englishName'],
                    'english_name_translation' => $surah['englishNameTranslation'],
                    'revelation_type' => $surah['revelationType'],
                ]
            );

            foreach ($surah['ayahs'] as $ayah) {
                Ayah::updateOrCreate(
                    ['number' => $ayah['number']],
                    [
                        'surah_id' => $surahModel->id,
                        'text' => $ayah['text'],
                        'text_normalized' => $this->normalizeArabic($ayah['text']),
                        'number_in_surah' => $ayah['numberInSurah'],
                        'juz' => $ayah['juz'],
                        'manzil' => $ayah['manzil'],
                        'page' => $ayah['page'],
                        'ruku' => $ayah['ruku'],
                        'hizb_quarter' => $ayah['hizbQuarter'],
                        'sajda' => is_array($ayah['sajda']) ? ($ayah['sajda']['recommended'] == 'true' ? 1 : 2 ) : 0, // 0 = No Sajda, 1 = Sajda recommended, 2 = Sajda obligatory
                    ]
                );
            }
        }

        $this->info('Quran data imported successfully.');
        return 0;
    }

    function normalizeArabic($text)
    {
        // Remove tashkeel (diacritics)
        $text = preg_replace('/[\p{Mn}]/u', '', $text);

        // Remove Tatweel
        $text = str_replace('ـ', '', $text);

        // Normalize special characters
        $text = str_replace(['ٱ', 'أ', 'إ', 'آ'], 'ا', $text); // normalize Alif variants

        return trim($text);
    }
}
