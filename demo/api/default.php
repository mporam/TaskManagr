<?php

if (!empty($_POST['filterOut'])) {
    $filterOut = $_POST['filterOut'];
    foreach($filterOut as $col => $val) {
        $SQL .= " AND " . $col . " NOT IN ('" . implode("','",$val) . "')";
    }
}

if (!empty($_POST['order'])) {
    $order = $_POST['order'];
    $SQL .= " ORDER BY $order";
}

if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
    $SQL .= " LIMIT $limit";
}