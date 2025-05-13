<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class DateHelper    
{
    public function age($dob)
    {
        $born = Carbon::createFromFormat('Y-m-d', $dob, new DateTimeZone('UTC'));
        if ($born === false) {
            return null;
        }

        // Calculate the age
        return $this->calculateAge($born->format('Y-m-d'));
    }
    
    private function calculateAge($born)
    {
        $from = new DateTime($born);
        $to = new DateTime('today');

        return $from->diff($to)->y;
    }
}