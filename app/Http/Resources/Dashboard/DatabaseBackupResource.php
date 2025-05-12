<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DatabaseBackupResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "path"=> $this->path,
            "full_path"=> $this->full_path,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
