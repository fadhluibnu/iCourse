<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
            'author' => 'sometimes|required',
            'title' => 'sometimes|required|min:20',
            'meta_desc' => 'sometimes|required|max:155',
            'slug' => [
                'sometimes',
                'required',
                Rule::unique('posts')->where(fn ($query) => $query->where('slug', '!=', $this->slug))
            ],
            'tag' => 'sometimes|required',
            'category' => 'sometimes|required',
            'cover' => 'sometimes|required|mimes:jpg,bmp,png,webp',
            'body' => 'sometimes|required',
        ];
    }
}
