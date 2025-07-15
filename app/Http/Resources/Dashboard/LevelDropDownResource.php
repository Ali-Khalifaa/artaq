<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelDropDownResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name,
            "first_sour" => $this->whenLoaded('levelTasks')->first()?->fromSurah?->name,
            "first_ayah" => $this->whenLoaded('levelTasks')->first()?->fromAyah?->number_in_surah,
            "first_page" => $this->whenLoaded('levelTasks')->first()?->fromAyah?->page,
            "last_sour"  => $this->whenLoaded('levelTasks')->last()?->toSurah?->name,
            "last_ayah" => $this->whenLoaded('levelTasks')->last()?->toAyah?->number_in_surah,
            "last_page"  => $this->whenLoaded('levelTasks')->last()?->toAyah?->page,
            "juz" => $this->whenLoaded('levelTasks')->first()?->fromAyah?->juz,
        ];
    }
}
