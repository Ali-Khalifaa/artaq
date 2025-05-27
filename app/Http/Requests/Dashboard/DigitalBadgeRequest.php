<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DigitalBadgeRequest extends FormRequest
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
            'name' => "required|string",
            "description" => "required|string",
            'level_id' => "required|exists:levels,id",
            'image' => $this->method() == 'PUT' ? 'nullable'.($this->hasFile('image')?'|file|mimes:jpeg,jpg,png,svg,webp':'') : 'required|file|mimes:png,svg,webp,jpg,jpeg' ,
        ];
    }
}
