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
            'level_id' => 'required|exists:levels,id',
            'track_id' => 'nullable|exists:tracks,id',
            'phone' => 'required|string|max:15',
            'guardian' => 'nullable|string',
            'guardian_phone' => 'nullable|string|max:15',
            'preservation_method_id' => 'required|exists:preservation_methods,id',
            'gender' => 'required',
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
