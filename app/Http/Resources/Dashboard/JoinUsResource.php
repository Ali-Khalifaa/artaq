<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JoinUsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'facebook' => $this->facebook,
            'twitter'    => $this->twitter,
            'instagram'      => $this->instagram,
            'linkedin'      => $this->linkedin,
            'youtube'      => $this->youtube,
            'android_app_client'      => $this->android_app_client,
            'ios_app_client'      => $this->ios_app_client,
            'android_app_teacher'      => $this->android_app_teacher,
            'ios_app_teacher'      => $this->ios_app_teacher,
            'phone'      => $this->phone,
        ];
    }
}
