<?php

namespace App\Http\Requests;

use App\API\UploadPhoto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Symfony\Component\VarDumper\VarDumper;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // var_dump($this->file('photo')[0]);
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
            'name' => 'sometimes|required|min:3',
            'photo' => 'sometimes|required',
            'username' => [
                'sometimes',
                'required',
                Rule::unique('users')->where(fn ($query) => $query->where('username', '!=', $this->username)),
            ],
            'email' => [
                'sometimes',
                'required',
                Rule::unique('users')->where(fn ($query) => $query->where('email', '!=', $this->email)),
            ],
            'password' => 'sometimes|required|min:6',
            'role' => 'sometimes|required',
        ];
    }

    // protected function passedValidation()
    // {
    //     $uploadPhoto = new UploadPhoto();
    //     $uploadPhoto = $uploadPhoto->operation('https://image-api-icourse.000webhostapp.com/api/upload-image', fopen($this->file('photo') , 'r'));
    //     echo $uploadPhoto;
    //     $this->replace([
    //         'photo' => $uploadPhoto,
    //         'password' => Hash::make($this->password)
    //     ]);
    // }
}
