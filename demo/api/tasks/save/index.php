<?php
if (!empty($_POST)) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

    if (!empty($_POST['tasks_id']) && !empty($_POST['tasks_status']) && count($_POST) == 2) {
        $id = $_POST['tasks_id'];
        $status =   $_POST['tasks_status'];
        $SQL = "UPDATE tasks SET `tasks_status`=$status WHERE `tasks_id` = $id";
        $query = $con->prepare($SQL);
    } else {
        $project =  $_POST['tasks_project'];
        $type =     $_POST['tasks_type'];
        $title =    trim($_POST['tasks_title']);
        $desc =     trim($_POST['tasks_desc']);
        $status =   $_POST['tasks_status'];
        $priority = $_POST['tasks_priority'];
        $deadline = $_POST['tasks_deadline'];
        $reporter = (empty($_POST['tasks_reporter']) ? $_SESSION['user_id'] : $_POST['tasks_reporter']);
        $assignee = (empty($_POST['tasks_assignee']) ? NULL : $_POST['tasks_assignee']);
        $deleted =  (empty($_POST['tasks_deleted']) ? '0' : $_POST['tasks_deleted']);

        if (!empty($_POST['tasks_id'])) {
            $id = $_POST['tasks_id'];
            $SQL = "UPDATE tasks SET ";

            if (!empty($type)) $SQL .= "`tasks_type`=$type, ";
            if (!empty($title)) $SQL .= "`tasks_title`='$title',  ";
            if (!empty($desc)) $SQL .= "`tasks_desc`='$desc', ";
            if (!empty($status)) $SQL .= "`tasks_status`=$status, ";
            if (!empty($priority)) $SQL .= "`tasks_priority`=$priority, ";
            if (!empty($deadline)) $SQL .= "`tasks_deadline`='$deadline', ";
            if (!empty($assignee)) $SQL .= "`tasks_assignee`=$assignee, ";
            if (!empty($reporter)) $SQL .= "`tasks_reporter`=$reporter, ";
            if (!empty($deleted)) $SQL .= "`tasks_deleted` = $deleted ,";
            $SQL .= "`tasks_updated`=CURDATE() WHERE `tasks_id` = $id";

    // for debugging only
    //echo $SQL;
    //exit;

            $query = $con->prepare($SQL);
        } else {
            $query = $con->prepare("SELECT COUNT('tasks_id') FROM tasks WHERE `tasks_projects` = $project");
            $query->execute();
            $count = (int)$query->fetchColumn();
            $count++;
            $SQL = "INSERT INTO tasks (`tasks_count`, `tasks_projects` ,`tasks_type` ,`tasks_title` ,`tasks_desc` ,`tasks_status` ,`tasks_priority` ,`tasks_deadline` ,`tasks_created` ,`tasks_updated` ,`tasks_assignee` ,`tasks_reporter`) VALUES ($count, $project, $type, '$title', '$desc', $status, $priority, '$deadline', CURDATE(), CURDATE(), $assignee, $reporter)";
            $query = $con->prepare($SQL);
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
	
	if (empty($_POST['tasks_id'])) {
		$lastid = $con->lastInsertId();
	} else {
		$lastid = $_POST['tasks_id'];
	}

    $query = $con->prepare("SELECT projects_code FROM projects WHERE projects_id = $project");
    $query->execute();
    $projectcode = $query->fetchColumn();

	$result = array(
		'code' => 200,
		'message' => 'Task Saved',
		'id' => $lastid,
        'project' => $projectcode
	);

    header('Content-Type: application/json');
    if ($env) {
        header('Query: ' . preg_replace("/\r|\n|\s/"," ",$SQL), false);
    }
	echo json_encode($result);

} else {
    header("HTTP/1.0 400 Bad Request", 400);
	die(json_encode(array('message' => 'Incomplete Data', 'code' => 400)));
}