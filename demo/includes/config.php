<?php
// this file includes all default settings
$root_dir = $_SERVER['DOCUMENT_ROOT'];

// get all url parts
$url_parts = explode('/', $_SERVER['SCRIPT_NAME']);
array_shift($url_parts);
array_pop($url_parts);
if (empty($url_parts)) $url_parts[0] = 'dashboard';

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

function get_gravatar($email, $default = '') {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?d=$default";
    return $url;
}

function get_page() {

}