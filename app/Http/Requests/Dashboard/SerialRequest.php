<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class SerialRequest extends FormRequest
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
        return [
            'type' => 'required|unique:serials,type' . ($this->method() == 'PUT' ? ',' . $this->serial->id : ''),
            'prefix' => 'required|string|max:255|unique:serials,prefix' . ($this->method() == 'PUT' ? ',' . $this->serial->id : ''),
            'start_number' => 'required|numeric',
        ];
    }
}
