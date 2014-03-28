<?php
if (!empty($_POST['tasks_id'])) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
        require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

        session_start();
 	$id =  $_POST['tasks_id'];
        $access = $_SESSION['user_type'];
        if ($access !== '1') die(json_encode(array(message => 'Permissions Denied', code => 502)));

	$query = $con->prepare("DELETE FROM tasks WHERE `tasks_id` = $id");

	try {	
		$query->execute();
	} catch (PDOException $e) {
		$result = array(
			code => 500,
			message => 'Delete Failed. Please try again.'
		);
		die(json_encode($result));
	}
	
	$result = array(
		code => 200,
		message => 'Task Permanently Deleted',
		id => $id
	);
	
	echo json_encode($result);

} else {
	die(json_encode(array(message => 'Internal Server Error', code => 500)));
}