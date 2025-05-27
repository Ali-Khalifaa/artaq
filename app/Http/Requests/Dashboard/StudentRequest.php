<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'phone' => 'required|string|max:15',
            'guardian_phone' => 'nullable|string|max:15',
            'memorization_type_id' => 'required|exists:memorization_types,id',
            'gender' => 'required',
            'nationality_id' => 'required|exists:nationalities,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'memorization_amount_id' => 'required|exists:memorization_amounts,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
            'password' => 'nullable|string|min:8',
            'confirmation' => 'nullable|same:password',

        ];
    }
}
