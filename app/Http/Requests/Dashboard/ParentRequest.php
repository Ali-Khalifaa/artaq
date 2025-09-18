<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ParentRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
            'password' => 'nullable|string|min:8',
            'confirmation' => 'nullable|same:password',
            'email' => "required|string|max:255|unique:students,email," . $this->route('parent'),
            'phone' => "required|string|max:255|unique:students,phone," . $this->route('parent'),
        ];
    }
}
