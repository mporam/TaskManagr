<?php

if (!empty($_POST['order'])) {
    $order = $_POST['order'];
    $SQL .= " ORDER BY $order";
}

if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
    $SQL .= " LIMIT $limit";
}

function get_gravatar($email, $size = 80, $default = '') {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    if (!is_numeric($size)) $size = 80;
    $url .= "?s=$size&d=$default";
    return $url;
}