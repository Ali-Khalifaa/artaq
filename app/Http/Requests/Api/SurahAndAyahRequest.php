<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SurahAndAyahRequest extends FormRequest
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
            'from_surah_id' => 'required|exists:surahs,id',
            'to_surah_id' => 'required|exists:surahs,id',
            'from_ayah_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $surahId = request()->input('from_surah_id');
                    if (!\DB::table('ayahs')->where('id', $value)->where('surah_id', $surahId)->exists()) {
                        $fail('هذه الاية لا تنتمي الى هذه الصورة');
                    }
                }
            ],
            'to_ayah_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $surahId = request()->input('to_surah_id');
                    if (!\DB::table('ayahs')->where('id', $value)->where('surah_id', $surahId)->exists()) {
                        $fail('هذه الاية لا تنتمي الى هذه الصورة');
                    }
                }
            ],
        ];
    }
}
