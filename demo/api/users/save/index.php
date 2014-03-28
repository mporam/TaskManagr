<?php
if (!empty($_POST)) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
        require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

	$name =  trim($_POST['users_name']);
        $email =  $_POST['users_email'];
        $password =  (empty($_POST['users_password']) ? '0' : $_POST['users_password']);
 	$type =  $_POST['users_type'];

	if (!empty($_POST['users_id'])) {
		$id = $_POST['users_id'];
                $salt = $_POST['users_salt'];
                $password = sha1($password . $salt);

		$query = $con->prepare("UPDATE users SET `users_name`='$name', `users_email`='$email', `users_password`='$password', `users_type`=$type WHERE `users_id` = $id");
	} else {
                $salt = rand(0, 9999);
                $password = sha1($password . $salt);

		$query = $con->prepare("INSERT INTO users (`users_name`, `users_email`, `users_password`, `users_type`) VALUES ('$name', '$email', '$password', $type)");
	}

	try {	
		$query->execute();
	} catch (PDOException $e) {
		$result = array(
			code => 500,
			message => 'Save Failed. Please try again.'
		);
		die(json_encode($result));
	}
	
	if (empty($_POST['users_id'])) {
		$lastid = $con->lastInsertId();
                $message = "User Created";
	} else {
		$lastid = $_POST['users_id'];
                $message = "User Updated";
	}
	$result = array(
		code => 200,
		message => $message,
		id => $lastid
	);
	
	echo json_encode($result);

} else {
	die(json_encode(array(message => 'Internal Server Error', code => 500)));
}