<?php

namespace App\Helpers;

use CodeIgniter\I18n\Time;

class DateHelper
{
    public static function formatDate($dateString)
    {
        $time = Time::createFromFormat('Y-m-d H:i:s', $dateString);
        return $time->format('d/m/Y H:i');
    }
}
