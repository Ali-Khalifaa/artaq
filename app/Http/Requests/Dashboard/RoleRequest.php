<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'name' =>  ['required','string',Rule::unique('sys_roles','name')->where(function ($query){
                return  $query->where('guard_name', 'admin_api');
            })->ignore($this->method() == 'PUT' ?$this->role->id : '')],
            'status' => "required|boolean",
            'permission' => "required|array",
            'permission.*' => 'required',
        ];
    }
}
