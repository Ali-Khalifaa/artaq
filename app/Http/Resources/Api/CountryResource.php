<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name,
            "image" => $this->image.'',
            "phone_code" => $this->phone_code,
            "status" => $this->status,
            "alpha_code" => $this->alpha_code,
            "number_of_phone_digits" => $this->number_of_phone_digits,
        ];
    }
}
