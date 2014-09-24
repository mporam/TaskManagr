<?php
    if (empty($_POST['table_name'])) {
        header("HTTP/1.0 400 Bad Request", 400);
        die(json_encode(array('message' => 'Bad Request', 'code' => 400)));
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

if ($query->errorCode() !== "00000") {
    header("HTTP/1.0 400 Bad Request", 400);
    die(json_encode(array('message' => 'Bad Request', 'code' => 400)));
}

$result = $query->fetchAll(PDO::FETCH_ASSOC);

if (empty($result)) {
    header("HTTP/1.0 404 Not Found", 404);
    die(json_encode(array('message' => 'Not Found', 'code' => 404)));
}

header('Content-Type: application/json');
if ($env) {
    header('Query: ' . preg_replace("/\r|\n|\s/"," ",$SQL), false);
}
echo json_encode($result);