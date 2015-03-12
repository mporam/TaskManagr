<?php
// this file includes all default settings
$root_dir = $_SERVER['DOCUMENT_ROOT'];

// get all url parts
$url_parts = explode('/', $_SERVER['SCRIPT_NAME']);
array_shift($url_parts);
array_pop($url_parts);
if (empty($url_parts)) $url_parts[0] = 'dashboard';
$url_parts = array_pad($url_parts, 3, '');

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

function error($string) {
    $backtrace = debug_backtrace();
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/api/logs/error.log', date('d/m/Y H:i:s', time()) . " : " . $string . " " . $backtrace[0]['file'] . ':' . $backtrace[0]['line'] . "\n", FILE_APPEND);
}