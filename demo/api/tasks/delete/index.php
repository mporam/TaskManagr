<?php
if (!empty($_POST['tasks_id']) || !empty($_POST['tasks_count'])) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
        require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

        session_start();
        $access = $_SESSION['user_type'];
        if ($access !== '1') die(json_encode(array(message => 'Permissions Denied', code => 502)));

 	$id =  $_POST['tasks_id'];
        if (empty($id)) {
            $count = $_POST['tasks_count'];
            $query = $con->prepare("DELETE FROM tasks WHERE `tasks_count` = $count");
            $return = $count;
        } else {
            $query = $con->prepare("DELETE FROM tasks WHERE `tasks_id` = $id");
            $return = $id;
        }

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
		id => $return
	);
	
	echo json_encode($result);

} else {
	die(json_encode(array(message => 'Internal Server Error', code => 500)));
}