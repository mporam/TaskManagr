<?php
if (!empty($_POST['users_id'])) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

    session_start();
 	$id =  $_POST['users_id'];
    $access = $_SESSION['users_type'];
    if ($access !== '1') {
        header("HTTP/1.0 401 Unauthorized", 401);
        die(json_encode(array(message => 'Permissions Denied', code => 401)));
    }

	$query = $con->prepare("DELETE FROM users WHERE `users_id` = $id");

	try {	
		$query->execute();
	} catch (PDOException $e) {
		$result = array(
			'code' => 500,
			'message' => 'Delete Failed. Please try again.'
		);
                header("HTTP/1.0 500 Internal Server Error", 500);
		die(json_encode($result));
	}
	
	$result = array(
		'code' => 200,
		'message' => 'User Permanently Deleted',
		'id' => $id
	);
	
	echo json_encode($result);

} else {
        header("HTTP/1.0 400 Bad Request", 400);
	die(json_encode(array('message' => 'Incomplete data', 'code' => 400)));
}