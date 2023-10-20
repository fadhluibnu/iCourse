<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|required',
            'slug' => [
                'sometimes',
                'required',
                Rule::unique('categories')->where(fn ($query) => $query->where('slug', '!=', $this->slug))
            ],
            'description' => 'sometimes|required',
            'image' => 'sometimes|required|mimes:jpg,bmp,png,webp'
        ];
    }
}
