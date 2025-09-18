<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "phone" => $this->phone,
            "email"       => $this->email,
            "code"       => $this->code,
            "status" => $this->status,
            "image" => $this->image,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
