<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
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
            'title' => ['required', Rule::unique('apartments')->ignore($this->apartment), 'max:150'],
            'thumb' => ['image', 'max:2024'],
            'address' => 'required',
            'description' => 'nullable|string',
            'rooms' => 'integer|nullable|between:1,20',
            'beds' => 'integer|nullable|between:1,20',
            'baths' => 'integer|nullable|between:1,30',
            'sqm' => 'integer|nullable|between:1,10000',
            'visibility' => 'nullable',
            'services' => ['exists:services,id'],
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ];
    }
}