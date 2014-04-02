<?php
if (!empty($_POST['projects_id'])) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

    session_start();
 	$id =  $_POST['projects_id'];
    $access = $_SESSION['users_type'];
    if ($access !== '1') die(json_encode(array('message' => 'Permissions Denied', 'code' => 502)));

	$query = $con->prepare("DELETE FROM projects WHERE `projects_id` = $id");

	try {	
		$query->execute();
	} catch (PDOException $e) {
		$result = array(
			'code' => 500,
			'message' => 'Delete Failed. Please try again.'
		);
		die(json_encode($result));
	}

    $query = $con->prepare("DELETE FROM tasks WHERE `tasks_projects` = $id");

	try {	
		$query->execute();
	} catch (PDOException $e) {
		$result = array(
			'code' => 500,
			'message' => 'Could not delete all project tasks, please delete manually'
		);
		die(json_encode($result));
	}

	$result = array(
		'code' => 200,
		'message' => 'Project Permanently Deleted',
		'id' => $id
	);
	
	echo json_encode($result);

} else {
	die(json_encode(array('message' => 'Internal Server Error', 'code' => 500)));
}