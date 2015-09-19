<?php

if (!empty($_POST['filterOut'])) {
    $filterOut = $_POST['filterOut'];
    foreach($filterOut as $col => $val) {
        $col = explode('_', $col)[0] . '.' . $col; // @todo: this feels like a hack - but a super clever one
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