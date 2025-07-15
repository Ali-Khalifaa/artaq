<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Level;
use App\Models\LevelTask;
use App\Models\Surah;
use Maatwebsite\Excel\Facades\Excel;

class ImportLevelsAndTasks extends Command
{
    protected $signature = 'import:levels';
    protected $description = 'Import Quran levels and tasks from excel file';

    public function handle()
    {
        Level::truncate();
        LevelTask::truncate();
        $fromNaasToFathaaPath = public_path('from_naas_to_fathaa.xlsx');
        $data = Excel::toArray([], $fromNaasToFathaaPath);
        foreach($data as $key =>  $row){
              $level = Level::create(['name' => "مستوى " . ($key + 1), 'preservation_method_id' => 2]);
            foreach($row as $item){
                if(isset($item[3]) && isset($item[4]) && is_integer($item[4]) && isset($item[5]) && isset($item[6]) && is_integer($item[6]) && isset($item[7]) && isset($item[8]) && is_integer($item[8]) && isset($item[9]) && isset($item[10]) && is_integer($item[10])){

                    $item[3] = str_replace(['أ', 'إ','آ'], 'ا', $item[3]);
                    $item[5] = str_replace(['أ', 'إ','آ'], 'ا', $item[5]);
                    $item[7] = str_replace(['أ', 'إ','آ'], 'ا', $item[7]);
                    $item[9] = str_replace(['أ', 'إ','آ'], 'ا', $item[9]);

                    $fromSurah = Surah::where('normalized_name','like',"%" . $item[3] . "%")->first();
                    $fromAyah = $fromSurah ? $fromSurah->ayahs()->where('number_in_surah', $item[4])->first() : null;
                    $toSurah = Surah::where('normalized_name','like',"%" . $item[5] . "%")->first();
                    $toAyah = $toSurah ? $toSurah->ayahs()->where('number_in_surah', $item[6])->first() : null;

                    $reviewFromSurah = Surah::where('normalized_name', 'like', '%' . $item[7] . '%')->first();
                    $reviewFromAyah = $reviewFromSurah ? $reviewFromSurah->ayahs()->where('number_in_surah', $item[8])->first() : null;
                    $reviewToSurah = Surah::where('normalized_name', 'like', '%' . $item[9] . '%')->first();
                    $reviewToAyah = $reviewToSurah ? $reviewToSurah->ayahs()->where('number_in_surah', $item[10])->first() : null;

                    if($fromSurah && $toSurah && $fromAyah && $toAyah)
                        LevelTask::create([
                            'level_id' => $level->id,
                            'from_surah_id' => $fromSurah->id,
                            'to_surah_id' => $toSurah->id,
                            'from_ayah_id' => $fromAyah->id,
                            'to_ayah_id' => $toAyah->id,

                            "review_from_surah_id" => $reviewFromSurah->id ?? null,
                            "review_to_surah_id" => $reviewToSurah->id ?? null,
                            "review_from_ayah_id" => $reviewFromAyah->id ?? null,
                            "review_to_ayah_id" => $reviewToAyah->id ?? null,
                        ]);
                }
            }
             $this->info("Importing Level: {($key) }");
        }


        $fromFathaToNasPath = public_path('from_fathaa_to_naas.xlsx');
        $data = Excel::toArray([], $fromFathaToNasPath);
        foreach($data as $key =>  $row){
              $level = Level::create(['name' => "مستوى " . ($key + 1), 'preservation_method_id' => 1]);
            foreach($row as $item){
                if(isset($item[2]) && isset($item[3]) && isset($item[4]) && isset($item[5]) && isset($item[6]) && isset($item[7]) && isset($item[8]) && isset($item[9])){
                    // Handle possible Arabic character variations (e.g., أ vs ا)
                    $item[2] = str_replace(['أ', 'إ','آ'], 'ا', $item[2]);
                    $item[4] = str_replace(['أ', 'إ','آ'], 'ا', $item[4]);
                    $item[6] = str_replace(['أ', 'إ','آ'], 'ا', $item[6]);
                    $item[8] = str_replace(['أ', 'إ','آ'], 'ا', $item[8]);
                    
                    $fromSurah = Surah::where('normalized_name','like',"%" . $item[2] . "%")->first();
                    $fromAyah = $fromSurah ? $fromSurah->ayahs()->where('number_in_surah', $item[3])->first() : null;
                    $toSurah = Surah::where('normalized_name','like',"%" . $item[4] . "%")->first();
                    $toAyah = $toSurah ? $toSurah->ayahs()->where('number_in_surah', $item[5])->first() : null;

                    $reviewFromSurah = Surah::where('normalized_name','like',"%" . $item[6] . "%")->first();
                    $reviewFromAyah = $reviewFromSurah ? $reviewFromSurah->ayahs()->where('number_in_surah', $item[7])->first() : null;
                    $reviewToSurah = Surah::where('normalized_name','like',"%" . $item[8] . "%")->first();
                    $reviewToAyah = $reviewToSurah ? $reviewToSurah->ayahs()->where('number_in_surah', $item[9])->first() : null;

                    if($fromSurah && $toSurah && $fromAyah && $toAyah)
                        LevelTask::create([
                            'level_id' => $level->id,
                            'from_surah_id' => $fromSurah->id,
                            'to_surah_id' => $toSurah->id,
                            'from_ayah_id' => $fromAyah->id,
                            'to_ayah_id' => $toAyah->id,

                            "review_from_surah_id" => $reviewFromSurah->id ?? null,
                            "review_to_surah_id" => $reviewToSurah->id ?? null,
                            "review_from_ayah_id" => $reviewFromAyah->id ?? null,
                            "review_to_ayah_id" => $reviewToAyah->id ?? null,
                        ]);
                }
            }
             $this->info("Importing Level: {($key) }");
        }
        return 0;
    }
}
