<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AyahResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "surah" => $this->surah?->name,
            "text" => $this->text,
            "text_normalized" => $this->text_normalized,
            "number_in_surah" => $this->number_in_surah,
            "juz" => $this->juz,
            "manzil" => $this->manzil,
            "page" => $this->page,
            "ruku" => $this->ruku,
            "hizb_quarter" => $this->hizb_quarter,
            "sajda" => $this->sajda,
        ];
    }
}
