<?php

namespace App\Helper;

class Helper
{
    public static function convertKmHToMS($kmh) {
        return number_format($kmh / 3.6, 2);
    }
}
