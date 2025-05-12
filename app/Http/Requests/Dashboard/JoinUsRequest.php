<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class JoinUsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->method() == 'PUT' ? last($this->segments()) : null;
        return [
            'facebook' => 'required|string',
            'twitter' => 'required|string',
            'instagram' => 'required|string',
            'linkedin' => 'required|string',
            'youtube' => 'required|string',
            'android_app_client' => 'required|string',
            'ios_app_client' => 'required|string',
            'android_app_teacher' => 'required|string',
            'ios_app_teacher' => 'required|string',
            'phone' => 'nullable|string',
        ];
    }
}
