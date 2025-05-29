<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QuranResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "number" => $this->number,
            "name"       => $this->name,
            "normalized_name"       => $this->normalized_name,
            "revelation_type" => $this->revelation_type,
            "verse_count" => $this->ayahs->count(),
            "page" => $this->ayahs->first()->page ?? null,
        ];
    }
}
