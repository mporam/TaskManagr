<?php
// this file includes all default settings
$root_dir = $_SERVER['DOCUMENT_ROOT'];

// set the environment, 1 is dev, 0 is live
$env = 1;

function showDate($date, $format = 'd/m/Y', $showTime = false) {
    $today = date($format);
    $stringDate = strtotime($date);
    $newDate = date($format, $stringDate);
    
    if ($showTime) {
        if ($today == $newDate) {
            return 'Today at ' . date('G:i.s', $stringDate);
        } else {
            return $newDate . ' ' . date('G:i.s', $stringDate);
        }
    } else {
        if ($today == $newDate) {
            return 'Today';
        } else {
            return $newDate;
        }
    }
}