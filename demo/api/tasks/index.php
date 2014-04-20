<?php
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
	
	session_start();
	$access = $_SESSION['users_type'];


    $SQL = "
SELECT * FROM tasks
    LEFT JOIN tasks_type 
        ON tasks.tasks_type = tasks_type.tasks_type_id
    LEFT JOIN tasks_status
        ON tasks.tasks_status = tasks_status.tasks_status_id
    LEFT JOIN tasks_priority
        ON tasks.tasks_priority = tasks_priority.tasks_priority_id
    LEFT JOIN projects
        ON tasks.tasks_projects = projects.projects_id 
    WHERE";

    // Get specific task
    if (!empty($_POST['tasks_id']) && strpos($_POST['tasks_id'],',') === false) {
        $tasks_id = $_POST['tasks_id'];
        $SQL .= " `tasks_id` = $tasks_id AND";
    } else if 
        (!empty($_POST['tasks_id']) && strpos($_POST['tasks_id'],',') !== false) {
            $task_ids = explode(',', $_POST['tasks_id']);
            foreach($task_ids as $task_id) {
                $SQL .= " `tasks_id` = $task_id OR";
            }
            $SQL = rtrim($SQL, ' OR');
            $SQL .= " AND";
    }

    if (!empty($_POST['projects_id'])) {
        $project_id = $_POST['projects_id'];
        $SQL .= " tasks_projects = $project_id AND";
    }

    if (!empty($_POST['tasks_type'])) {
        $task_type = $_POST['tasks_type'];
        $SQL .= " tasks_type_id = $task_type AND";
    }

    if (!empty($_POST['tasks_status'])) {
        $task_status = $_POST['tasks_status'];
        $SQL .= " tasks_status_id = $task_status AND";
    }

    if (!empty($_POST['tasks_priority'])) {
        $task_priority= $_POST['tasks_priority'];
        $SQL .= " tasks_priority_id = $task_priority AND";
    }

    if (!empty($_POST['tasks_assignee'])) {
        $task_assignee = $_POST['tasks_assignee'];
        $SQL .= " tasks_assignee = $task_assignee AND";
    }

    if (!empty($_POST['tasks_reporter'])) {
        $task_reporter = $_POST['tasks_reporter'];
        $SQL .= " tasks_reporter = $task_reporter AND";
    }

    if (!empty($_POST['tasks_related'])) {
        $task_related = $_POST['tasks_related'];
        $SQL .= " tasks_related = $task_related AND";
    }
	
	// hide tasks if not admin
	if ($access !== '0') {
		$SQL .= " tasks_deleted <> 1 AND";
	}

    // this must be the last if!!
    if (!empty($_POST['tasks_deadline'])) {
        $task_deadline = $_POST['tasks_deadline'];
        $task_deadline_start = DATE('Y-d-m');
        if (!empty($_POST['tasks_deadline_start'])) $task_deadline_start = $_POST['tasks_deadline_start'];
        $SQL .= " tasks_deadline BETWEEN 'CURDATE()' AND '$task_deadline' AND";
    }

$SQL = rtrim($SQL, ' OR');
$SQL = rtrim($SQL, ' AND');
$SQL = rtrim($SQL, ' WHERE');

    require($_SERVER['DOCUMENT_ROOT'] . '/api/default.php');

// for debugging
// echo $SQL;
// exit;

$query = $con->prepare($SQL);
$query -> execute();
$tasks = $query->fetchAll(PDO::FETCH_ASSOC);

foreach($tasks as $k=>$task) {
    $tasks_assignee = $task['tasks_assignee'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $tasks_assignee");
    $query -> execute();
    $assignee = $query->fetch(PDO::FETCH_ASSOC);
    $tasks[$k]['tasks_assignee'] = (empty($assignee) ? 'Unassigned' : $assignee);

    $tasks_reporter= $task['tasks_reporter'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $tasks_reporter");
    $query -> execute();
    $reporter = $query->fetch(PDO::FETCH_ASSOC);
    $tasks[$k]['tasks_reporter'] = (empty($reporter) ? 'Unassigned' : $reporter);

    $tasks_related = $task['tasks_related'];
    $query = $con->prepare("SELECT `tasks_id`, `tasks_title` FROM tasks WHERE `tasks_id` = $tasks_related");
    $query -> execute();
    $tasks[$k]['tasks_related'] = $query->fetch(PDO::FETCH_ASSOC);

    $projects_lead = $task['projects_lead'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $projects_lead");
    $query -> execute();
    $lead = $query->fetch(PDO::FETCH_ASSOC);
    $tasks[$k]['projects_lead'] = (empty($lead) ? 'Unassigned' : $lead);

    $projects_client = $task['projects_client'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $projects_client");
    $query -> execute();
    $client = $query->fetch(PDO::FETCH_ASSOC);
    $tasks[$k]['projects_client'] = (empty($client) ? 'Unassigned' : $client);
	
	$projects_manager = $task['projects_manager'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $projects_manager");
    $query -> execute();
    $manager = $query->fetch(PDO::FETCH_ASSOC);
    $tasks[$k]['projects_manager'] = (empty($manager) ? 'Unassigned' : $manager);
}

header('Content-Type: application/json');
echo json_encode($tasks);