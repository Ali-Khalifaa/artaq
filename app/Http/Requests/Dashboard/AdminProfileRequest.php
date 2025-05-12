<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AdminProfileRequest extends FormRequest
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
        $admin = auth()->guard('admin_api')?->user();
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:sys_admins,email,' . $admin->id,
            'phone' => 'required|string|unique:sys_admins,phone,' .$admin->id,
            'password' => 'nullable|string|min:8',
            'confirmation' => 'nullable|same:password',
        ];

    }
}
