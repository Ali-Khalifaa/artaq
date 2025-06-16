<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'phone' => 'required|string|max:15',
            'id_number' => 'nullable|string|max:20|unique:teachers,id_number,' . $this->teacher,
            'gender' => 'required',
            'admin_id' => 'nullable|exists:admins,id',
            'nationality_id' => 'required|exists:nationalities,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
            'password' => 'nullable|string|min:8',
            'confirmation' => 'nullable|same:password',
            'birth_date' => 'nullable|date',
            'email' => 'nullable|email|max:255|unique:teachers,email,' . $this->teacher,
            'juz_count' => 'nullable|numeric|min:1',
            'experience_years' => 'nullable|numeric|min:0',
            'Quran_licenses' => 'nullable|numeric|min:0',
            'salary' => 'nullable|numeric|min:0',
            'cv' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,svg',

        ];
    }
}
