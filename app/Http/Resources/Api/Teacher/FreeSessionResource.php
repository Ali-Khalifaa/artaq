<?php

namespace App\Http\Resources\Api\Teacher;

use App\Models\FreeSession;
use App\Models\Rating;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FreeSessionResource extends JsonResource
{

    public function toArray($request)
    {
        $rating = Rating::whereRatedId($this->teacher_id)->whereRatedType(Teacher::class)->whereModelId($this->id)->whereModelType(FreeSession::class)->first();

        return [
            "id"  => $this->id,
            "student"       => new StudentResource($this->student),
            'status' => [
                'name' => $this->status->translated(),
                'value' => $this->status->value,
                'color' => $this->status->colorCode(),
            ],
            "rating" => $rating ? [
                'rate' => $rating->rate,
                'comment' => $rating->comment
            ] : null,
            "number_of_mins" => $this->number_of_mins,
            "from_surah" => $this->fromSurah?->name,
            "to_surah" => $this->toSurah?->name,
            "from_ayah" => $this->fromAyah?->text,
            "to_ayah" => $this->toAyah?->text,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
