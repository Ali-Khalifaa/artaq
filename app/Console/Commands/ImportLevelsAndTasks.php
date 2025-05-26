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
                if(isset($item[3]) && isset($item[4]) && is_integer($item[4]) && isset($item[5]) && isset($item[6]) && is_integer($item[6])){
                    $fromSurah = Surah::where('normalized_name','like',"%" . $item[3] . "%")->first();
                    $fromAyah = $fromSurah ? $fromSurah->ayahs()->where('number_in_surah', $item[4])->first() : null;
                    $toSurah = Surah::where('normalized_name','like',"%" . $item[5] . "%")->first();
                    $toAyah = $toSurah ? $toSurah->ayahs()->where('number_in_surah', $item[6])->first() : null;

                    if($fromSurah && $toSurah && $fromAyah && $toAyah)
                        LevelTask::create([
                            'level_id' => $level->id,
                            'from_surah_id' => $fromSurah->id,
                            'to_surah_id' => $toSurah->id,
                            'from_ayah_id' => $fromAyah->id,
                            'to_ayah_id' => $toAyah->id,
                        ]);
                }
            }
             $this->info("Importing Level: {($key) }");
        }


        $fromNaasToFathaaPath = public_path('from_fathaa_to_naas.xlsx');
        $data = Excel::toArray([], $fromNaasToFathaaPath);
        foreach($data as $key =>  $row){
              $level = Level::create(['name' => "مستوى " . ($key + 1), 'preservation_method_id' => 1]);
            foreach($row as $item){
                if(isset($item[3]) && isset($item[4]) && is_integer($item[4]) && isset($item[5]) && isset($item[6]) && is_integer($item[6])){
                    $fromSurah = Surah::where('normalized_name','like',"%" . $item[3] . "%")->first();
                    $fromAyah = $fromSurah ? $fromSurah->ayahs()->where('number_in_surah', $item[4])->first() : null;
                    $toSurah = Surah::where('normalized_name','like',"%" . $item[5] . "%")->first();
                    $toAyah = $toSurah ? $toSurah->ayahs()->where('number_in_surah', $item[6])->first() : null;

                    if($fromSurah && $toSurah && $fromAyah && $toAyah)
                        LevelTask::create([
                            'level_id' => $level->id,
                            'from_surah_id' => $fromSurah->id,
                            'to_surah_id' => $toSurah->id,
                            'from_ayah_id' => $fromAyah->id,
                            'to_ayah_id' => $toAyah->id,
                        ]);
                }
            }
             $this->info("Importing Level: {($key) }");
        }
        return 0;
    }
}
