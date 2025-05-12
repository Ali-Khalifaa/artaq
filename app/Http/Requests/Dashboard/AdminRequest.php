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
            'email' => 'required|string|email|unique:sys_admins,email'.($this->method() == 'PUT' ? ',' . $this->admin->id : '') ,
            'password' => 'required|string|min:8',
            'confirmation' => 'required|same:password',
            'phone' => 'required|string|unique:sys_admins,phone'. ($this->method() == 'PUT' ? ',' . $this->admin->id : ''),
            'role_name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5048',
            "status"            =>  "required|boolean",
        ];

        if($this->method() == 'PUT'){
            $rules['password'] = 'nullable|string|min:8';
            $rules['confirmation'] = 'nullable|same:password';
        }
        return $rules;
    }
}
