<?php
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

    $SQL = "SELECT * FROM users 
        LEFT JOIN users_type ON users.users_type = users_type.users_type_id 
        WHERE";

    // Get user based on id
    if (!empty($_POST['users_id'])) {
        $users_id = $_POST['users_id'];
        $SQL .= " `users_id` = $users_id AND";
    }
    
    // Get user by name
    if (!empty($_POST['users_name'])) {
        $users_name = $_POST['users_name'];
        $SQL .= " `users_name` = '$users_name' AND";
    }

    // get user by type
    if (!empty($_POST['users_type'])) {
        $users_type= $_POST['users_type'];
        $SQL .= " `users_type` = $users_type AND";
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

if ($query->errorCode() !== "00000") {
    header("HTTP/1.0 400 Bad Request", 400);
    die(json_encode(array('message' => 'Bad Request', 'code' => 400)));
}

$users = $query->fetchAll(PDO::FETCH_ASSOC);

if (empty($users)) {
    header("HTTP/1.0 404 Not Found", 404);
    die(json_encode(array('message' => 'No Users Found', 'code' => 404)));
}

foreach($users as $k => $user) {
    if (empty($user['users_image'])) {
        $users[$k]['users_image'] = get_gravatar($user['users_email']);
    }
}

header('Content-Type: application/json');
echo json_encode($users);