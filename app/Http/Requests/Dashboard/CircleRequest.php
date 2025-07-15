<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CircleRequest extends FormRequest
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
            'name' => "required|string|max:255|unique:circles,name," . $this->route('circle'),
            'circle_type_id' => 'nullable|exists:circle_types,id',
            'gender' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after_or_equal:start_time',
            'duration' => 'required|array',
            'duration.*.day' => 'required',
            'duration.*.start_time' => 'required',
            'duration.*.end_time' => 'required|after_or_equal:duration.*.start_time',
            'status' => 'required|boolean',
        ];
    }
}
