<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'author' => 'required',
            'title' => 'required|min:20',
            'meta_desc' => 'required|max:155',
            'slug' => 'required|unique:posts,slug',
            'tag' => 'required',
            'category' => 'required',
            'cover' => 'required|mimes:jpg,bmp,png,webp',
            'body' => 'required',
        ];
    }
}
