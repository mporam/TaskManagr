<?php

set_time_limit(0);
// this file includes all default settings
$GLOBALS['root'] = $_SERVER['DOCUMENT_ROOT'];

// get all url parts
$url_parts = explode('/', $_SERVER['SCRIPT_NAME']);
array_shift($url_parts);
array_pop($url_parts);
if (empty($url_parts)) $url_parts[0] = 'dashboard';
$GLOBALS['url_parts'] = array_pad($url_parts, 3, '');

// set the environment, 1 is dev, 0 is live
$GLOBALS['environment'] = 1;

function showDate($date, $format = 'd/m/Y', $showTime = false) {
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

function get_gravatar($email, $default = '') {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?d=$default";
    return $url;
}

register_shutdown_function('error');

function error($error = null) {
    $message = date('d/m/Y H:i:s', time()) . " : ";
    if (empty($error)) {
        $error = error_get_last();
        $message .= $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line'];
    } else {
        $backtrace = debug_backtrace();
        $message .= $error . " " . $backtrace[0]['file'] . ':' . $backtrace[0]['line'];
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/api/logs/error.log', $message . "
    \n\r", FILE_APPEND);
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoloader.php');

$GLOBALS['js'] = new javascript();