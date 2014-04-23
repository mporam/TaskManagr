<?php
if (!empty($_POST)) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
        require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');


	$project   =  $_POST['tasks_project'];
        $type   =  $_POST['tasks_type'];
        $title =  trim($_POST['tasks_title']);
	$desc =  trim($_POST['tasks_desc']);
        $status = $_POST['tasks_status'];
	$priority = $_POST['tasks_priority'];
	$deadline =  $_POST['tasks_deadline'];
	$reporter =  (empty($_POST['tasks_reporter']) ? $_SESSION['user_id'] : $_POST['tasks_reporter']);
	$assignee = (empty($_POST['tasks_assignee']) ? NULL : $_POST['tasks_assignee']);
	$deleted = (empty($_POST['tasks_deleted']) ? '0' : $_POST['tasks_deleted']);

	if (!empty($_POST['tasks_id'])) {
		$id = $_POST['tasks_id'];
		$query = $con->prepare("UPDATE tasks SET `tasks_projects`=$project, `tasks_type`=$type, `tasks_title`='$title', `tasks_desc`='$desc', `tasks_status`=$status, `tasks_priority`=$priority, `tasks_deadline`='$deadline', `tasks_updated`=CURDATE(), `tasks_assignee`=$assignee, `tasks_reporter`=$reporter, `tasks_deleted` = $deleted WHERE `tasks_id` = $id");
	} else {
                $query = $con->prepare("SELECT COUNT('tasks_id') FROM tasks WHERE `tasks_projects` = $project");
                $query->execute();
                $count = (int)$query->fetchColumn();
                $count++;
		$query = $con->prepare("INSERT INTO tasks (`tasks_count`, `tasks_projects` ,`tasks_type` ,`tasks_title` ,`tasks_desc` ,`tasks_status` ,`tasks_priority` ,`tasks_deadline` ,`tasks_created` ,`tasks_updated` ,`tasks_assignee` ,`tasks_reporter`) VALUES ($count, $project, $type, '$title', '$desc', $status, $priority,  '$deadline', CURDATE(), CURDATE(), $assignee, $reporter)");
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
	
	if (empty($_POST['tasks_id'])) {
		$lastid = $con->lastInsertId();
	} else {
		$lastid = $_POST['tasks_id'];
	}
	$result = array(
		code => 200,
		message => 'Task Saved',
		id => $lastid
	);
	
	echo json_encode($result);

} else {
	die(json_encode(array(message => 'Internal Server Error', code => 500)));
}