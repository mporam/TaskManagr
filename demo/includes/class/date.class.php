<?php

class date {

    public static function validateDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') == $date;
    }

    public static function showDate($date, $format = 'd/m/Y', $showTime = false) {
        if ($date == '0000-00-00') {
            return 'Not set';
        }
        $today = date($format);
        $stringDate = strtotime($date);
        $newDate = date($format, $stringDate);

        if ($showTime) {
            if ($today == $newDate) {
                return 'Today at ' . date('G:i', $stringDate);
            } else {
                return $newDate . ' ' . date('G:i', $stringDate);
            }
        } else {
            if ($today == $newDate) {
                return 'Today';
            } else {
                return $newDate;
            }
        }
    }
} 