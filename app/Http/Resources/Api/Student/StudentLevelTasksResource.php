<?php

namespace App\Http\Resources\Api\Student;

use App\Models\IntensiveSession;
use App\Models\Rating;
use App\Models\Student;
use App\Models\StudentLevelTask;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentLevelTasksResource extends JsonResource
{
    public function toArray($request)
    {
        $rating = Rating::whereRatedId($this?->student_id)->whereRatedType(Student::class)->whereModelId($this->id)->whereModelType(StudentLevelTask::class)->first();
        return [
            "id"  => $this->id,
            "teacher"       => new TeacherResource($this->circle?->teacher),

            "manhag" => $this?->fromSurah?->name . " ( " . $this?->fromAyah?->text . " )  الى " . $this?->toSurah?->name . " ( " . $this?->toAyah?->text . " ) ",
            "review" => $this?->reviewFromSurah?->name . " ( " . $this?->reviewFromAyah?->text . " )  الى " . $this?->reviewToSurah?->name . " ( " . $this?->reviewToAyah?->text . " ) ",

            "date" => $this->date."",
            "rating" => $rating ? [
                'rate' => $rating->rate."",
                'comment' => $rating->comment.""
            ]:"",
            "date" => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
