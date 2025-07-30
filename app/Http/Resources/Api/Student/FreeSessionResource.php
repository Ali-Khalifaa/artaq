<?php

namespace App\Http\Resources\Api\Student;

use App\Models\FreeSession;
use App\Models\Rating;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FreeSessionResource extends JsonResource
{

    public function toArray($request)
    {
        $rating = Rating::whereRatedId($this->student_id)->whereRatedType(Student::class)->whereModelId($this->id)->whereModelType(FreeSession::class)->first();
        return [
            "id"  => $this->id,
            "teacher"       => new TeacherResource($this->teacher),
            'status' => [
                'name' => $this->status->translated(),
                'value' => $this->status->value,
                'color' => $this->status->colorCode(),
            ],
            "number_of_mins" => $this->number_of_mins,
            "rating" => $rating ? [
                'rate' => $rating->rate,
                'comment' => $rating->comment
            ]:null,
            "from_surah" => $this->fromSurah?->name,
            "to_surah" => $this->toSurah?->name,
            "from_ayah" => $this->fromAyah?->text,
            "to_ayah" => $this->toAyah?->text,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
