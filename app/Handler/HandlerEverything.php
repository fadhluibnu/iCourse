<?php

namespace App\Handler;

use Carbon\Carbon;

class HandlerEverything
{
    public function dateFormat($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y');
    }
}