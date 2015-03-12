<?php

if (!empty($_POST['order'])) {
    $order = $_POST['order'];
    $SQL .= " ORDER BY $order";
}

if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
    $SQL .= " LIMIT $limit";
}