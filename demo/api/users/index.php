<?php
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

    $SQL = "SELECT * FROM users WHERE";

    // Get specific project
    if (!empty($_POST['users_id'])) {
        $users_id = $_POST['users_id'];
        $SQL .= " `users_id` = $users_id AND";
    }

    if (!empty($_POST['users_type'])) {
        $users_type= $_POST['users_type'];
        $SQL .= " `users_type` = $users_type AND";
    }
    
    if (!empty($_POST['users_name'])) {
        $users_name= $_POST['users_name'];
        $SQL .= " `users_name` = '$users_name' AND";
    }

    $SQL = rtrim($SQL, ' AND');
    $SQL = rtrim($SQL, ' OR');
    $SQL = rtrim($SQL, ' WHERE');

    require($_SERVER['DOCUMENT_ROOT'] . '/api/default.php');

// for debugging
// echo $SQL;
// exit;

$query = $con->prepare($SQL);
$query -> execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($users);