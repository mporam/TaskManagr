<?php

if (!empty($_POST['order'])) {
    $order = $_POST['order'];
    $SQL .= " ORDER BY $order";
}

if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
    $SQL .= " LIMIT $limit";
}

function get_gravatar($email, $default = '') {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?d=$default";
    return $url;
}