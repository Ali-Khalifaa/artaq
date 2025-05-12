<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
        $id = $this->method() == 'PUT' ? last($this->segments()) : null;
        return [
            "status"                     => "required|boolean",
            "code"                       => "required|string|max:10|unique:sys_languages,code,".$id,
            'flag'                       => ($this->method() == 'PUT' ? 'nullable' : 'required') . '|file|mimes:jpeg,jpg,png,svg,webp',
            "translations"               => "nullable|array",
            "translations.*.title"       => "required|string",
            "translations.*.description" => "nullable|string",
        ];
    }
}
