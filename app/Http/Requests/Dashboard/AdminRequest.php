<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:admins,email'.($this->method() == 'PUT' ? ',' . $this->admin->id : '') ,
            'password' => 'required|string|min:8',
            'confirmation' => 'required|same:password',
            'phone' => 'required|string|unique:admins,phone'. ($this->method() == 'PUT' ? ',' . $this->admin->id : ''),
            'role_name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5048',
            "status"            =>  "required|boolean",
            'id_number' => 'nullable|string|max:20|unique:admins,id_number'.($this->method() == 'PUT' ? ',' . $this->admin->id : '') ,
            'gender' => 'required',
            'nationality_id' => 'required|exists:nationalities,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'birth_date' => 'nullable|date',
            'juz_count' => 'nullable|numeric|min:1|max:30',
            'experience_years' => 'nullable|numeric|min:0',
            'Quran_licenses' => 'nullable|numeric|min:0',
            'salary' => 'nullable|numeric|min:0',
        ];

        if($this->method() == 'PUT'){
            $rules['password'] = 'nullable|string|min:8';
            $rules['confirmation'] = 'nullable|same:password';
        }
        return $rules;
    }
}
