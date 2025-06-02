<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelTaskResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name,
            "preservation_method_id" => $this->level?->preservation_method_id,
            "level_id"   => $this->level_id,
            "from_surah_id" => $this->from_surah_id,
            "to_surah_id" => $this->to_surah_id,
            "from_ayah_id" => $this->from_ayah_id,
            "to_ayah_id" => $this->to_ayah_id,
            "level" => new LevelResource($this->whenLoaded('level')),
            "from_surah" => $this->whenLoaded('fromSurah'),
            "to_surah" => $this->whenLoaded('toSurah'),
            "from_ayah" => $this->whenLoaded('fromAyah'),
            "to_ayah" => $this->whenLoaded('toAyah'),
        ];
    }
}
