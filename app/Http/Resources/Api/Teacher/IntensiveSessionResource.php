<?php

namespace App\Http\Resources\Api\Teacher;

use App\Models\IntensiveSession;
use App\Models\Rating;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class IntensiveSessionResource extends JsonResource
{
    public function toArray($request)
    {
        $intensiveRequest  = $this->intensiveStudy?->intensiveRequest;
        $rating = Rating::whereRatedId($intensiveRequest?->teacher_id)->whereRatedType(Teacher::class)->whereModelId($this->id)->whereModelType(IntensiveSession::class)->first();
        return [
            "id"  => $this->id,
            "student"       => new StudentResource($intensiveRequest->student),
            'status' => [
                'name' => $this->status->translated(),
                'value' => $this->status->value,
                'color' => $this->status->colorCode(),
            ],
            "manhag" => $this->intensiveStudy->fromSurah?->name." ( ".$this->intensiveStudy->fromAyah?->text." )  الى ". $this->intensiveStudy->toSurah?->name." ( ".$this->intensiveStudy->toAyah?->text." ) ",
            "tasme3" => $this->fromSurah?->name." ( ".$this->fromAyah?->text." )  الى ". $this->toSurah?->name." ( ".$this->toAyah?->text." ) ",
            "number_of_mins" => $this->number_of_mins."",
            "date" => $this->date."",
            "rating" => $rating ? [
                'rate' => $rating->rate."",
                'comment' => $rating->comment.""
            ]:"",
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
