<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class LevelTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'level_id' => "required|exists:levels,id",
            'from_surah_id' => "required|exists:surahs,id",
            'to_surah_id' => "required|exists:surahs,id",
            'from_ayah_id' => "required|exists:ayahs,id",
            'to_ayah_id' => "required|exists:ayahs,id",
        ];
    }
}
