<?php

namespace App\Http\Resources\Api\Teacher;

use App\Models\CircleSessionStudent;
use App\Models\IntensiveSession;
use App\Models\Rating;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CircleSessionStudentResource extends JsonResource
{
    public function toArray($request)
    {

        $rating = Rating::whereRatedId($this->circleSession?->teacher_id)->whereRatedType(Teacher::class)->whereModelId($this->id)->whereModelType(CircleSessionStudent::class)->first();
        return [
            "id"  => $this->id,
            "attends"  => $this->attends."",
            "is_passed"  => $this->is_passed."",
            "student"       => [
                "name" => $this->student?->name ?? $this->student?->phone,
                "phone" => $this->student?->phone,
                "image" => $this->student?->image."",
            ],
            "tasme3" => $this->studentLevelTask?->fromSurah?->name . " ( " . $this->studentLevelTask?->fromAyah?->text . " )  الى " . $this->studentLevelTask?->toSurah?->name . " ( " . $this->studentLevelTask?->toAyah?->text . " ) ",
            "review" => $this->studentLevelTask?->reviewFromSurah?->name . " ( " . $this->studentLevelTask?->reviewFromAyah?->text . " )  الى " . $this->studentLevelTask?->reviewToSurah?->name . " ( " . $this->studentLevelTask?->reviewToAyah?->text . " ) ",
            "rating" => $rating ? [
                'rate' => $rating->rate."",
                'comment' => $rating->comment.""
            ]:"",
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
