<?php

namespace App\Http\Requests\Api\Student;

use Illuminate\Foundation\Http\FormRequest;

class CompleteStudentRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'level_id' => [
                'required_if:track_id,2',
                function ($attribute, $value, $fail) {
                    if ($this->has('preservation_method_id') && $this->track_id == 2) {
                        $preservationMethodId = $this->input('preservation_method_id');
                        $exists = \DB::table('levels')
                            ->where('id', $value)
                            ->where('preservation_method_id', $preservationMethodId)
                            ->exists();
                        if (!$exists) {
                            $fail('The selected level does not belong to the specified preservation method.');
                        }
                    }
                },
            ],
             'preservation_method_id' => ['required_if:track_id,2,3', function ($attribute, $value, $fail) {
                if ($this->track_id == 3 && !in_array($value, [4, 3])) {
                    $fail('اتجاه الحفظ غير صالح للمسار المكثف');
                }
                if ($this->track_id == 2 && !in_array($value, [1, 2])) {
                    $fail('اتجاه الحفظ غير صالح لمسار الحلقات');
                }
            }],
            'track_id' => 'required|exists:tracks,id',
            'guardian' => 'nullable|string',
            'guardian_phone' => 'nullable|string|max:15',

            'gender' => 'required|in:male,female',
            'nationality_id' => 'required|exists:nationalities,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'memorization_amount_id' => 'required|exists:memorization_amounts,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_number' => "required|max:255|unique:students,id_number," . $this->route('student'),
            'juz_count' => 'nullable|integer|min:0|max:30',
        ];
    }
}
