<?php
    if (empty($_POST['table_name'])) {
        header('Content-Type: application/json');
        echo 'null';
        exit;
    }

    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

    $SQL = "SELECT * FROM ";


    $table = $_POST['table_name'];
    $SQL .= "$table";

    require($_SERVER['DOCUMENT_ROOT'] . '/api/default.php');

// for debugging
// echo $SQL;
// exit;

$query = $con->prepare($SQL);
$query -> execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($result);