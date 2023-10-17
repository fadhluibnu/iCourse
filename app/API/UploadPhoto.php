<?php

namespace App\API;

use Illuminate\Support\Facades\Http;

class UploadPhoto
{
    public function operation($url, $image)
    {
        $profil = Http::acceptJson()->attach(
            'image',
            $image
        )->post($url, [
            'code' => '38@0$%8%^8/8471'
        ]);

        return $profil['image'];
    }
}
