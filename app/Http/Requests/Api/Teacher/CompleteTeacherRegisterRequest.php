<?php

namespace App\Http\Requests\Api\Teacher;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class CompleteTeacherRegisterRequest extends FormRequest
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
     *
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'name' => 'required|string|max:255',
            'id_number' => 'nullable|string|max:20|unique:teachers,id_number,' . $this->route('teacher'),
            'gender' => 'required',
            'nationality_id' => 'required|exists:nationalities,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:8',
            'confirmation' => 'nullable|same:password',
            'birth_date' => 'nullable|date',
            'email' => 'nullable|email|max:255|unique:teachers,email,' . $this->route('teacher'),
            'juz_count' => 'nullable|numeric|min:1|max:30',
            'experience_years' => 'nullable|numeric|min:0',
            'Quran_licenses' => 'nullable|numeric|min:0',
            'cv' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,svg',
        ];

        if (Setting::first()?->login_method == "email") {
            $rules['phone'] = "required|unique:teachers,phone";
        } else {
            $rules['email'] = "required|unique:teachers,email";
        }
        return $rules;
    }
}
