<?php
if (!empty($_POST)) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
    require($_SERVER['DOCUMENT_ROOT'] . "/includes/phpmailer/class.phpmailer.php");

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
        if ($password) {
            $password = sha1($password . $salt);
            $message = "Hi " . $name . ",

You have been set up as a new user on Task Managr.
Please click the link below to login:

http://" . $_SERVER['HTTP_HOST'] . "/login/

Task Managr";
            $query = $con->prepare("INSERT INTO users (`users_name`, `users_email`, `users_password`, `users_salt`, `users_type`) VALUES ('$name', '$email', '$password', '$salt', $type)");
        } else {
            $reset = sha1($email);
            $message = "Hi " . $name . ",

You have been set up as a new user on Task Managr.
Please click the link below to set up your password:

http://" . $_SERVER['HTTP_HOST'] . "/login/reset.php?reset=" . $reset . "

Once you have set up your password you will be able to upload a user image and edit your profile details.

Task Managr";
            $query = $con->prepare("INSERT INTO users (`users_name`, `users_email`, `users_password`, `users_salt`, `users_type`, `users_reset`) VALUES ('$name', '$email', '$password', '$salt', $type, '$reset')");
        }
        
        $mail = new PHPMailer();
        $mail->IsSMTP();  // telling the class to use SMTP
        $mail->Host     = "10.168.1.70"; // SMTP server
        $mail->SetFrom("no-reply@taskmanagr.co.uk", 'Task Managr Notification');
        $mail->AddAddress($email);
        $mail->Subject  = 'New Task Managr Account';
        $mail->Body     = $message;
        $mail->WordWrap = 78;

        if(!$mail->Send()) {   
            $result = array(
                'code' => 500,
                'message' => 'Save Failed. Please try again.'
            );
            header("HTTP/1.0 500 Internal Server Error", 500);
            die(json_encode($result));
        }
	}

	try {	
		$query->execute();
	} catch (PDOException $e) {
		$result = array(
			'code' => 500,
			'message' => 'Save Failed. Please try again.'
		);
                header("HTTP/1.0 500 Internal Server Error", 500);
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
		'code' => 200,
		'message' => $message,
		'id' => $lastid
	);
	
	echo json_encode($result);

} else {
        header("HTTP/1.0 400 Bad Request", 400);
	die(json_encode(array('message' => 'Incomplete data', 'code' => 400)));
}