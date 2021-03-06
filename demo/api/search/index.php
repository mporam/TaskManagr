<?php
if (empty($_POST['search_type'])) {
    $result = array(
        'code' => 400,
        'message' => 'Please specify search type'
    );
    header("HTTP/1.0 400 Bad Request", 400);
    die(json_encode($result));
}

if (empty($_POST['search_term'])) {
    $result = array(
        'code' => 400,
        'message' => 'Please specify search term'
    );
    header("HTTP/1.0 400 Bad Request", 400);;
    die(json_encode($result));
}

    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
    session_start();
    $access = $_SESSION['users_type'];
    $term = $_POST['search_term'];

if ($_POST['search_type'] == 'tasks') {
	
    // pass in search field - default to task title
    $field = (!empty($_POST['field']) ? $_POST['field']:'tasks_title');
    
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

    $SQL .= " (
        `" . $field . "` LIKE '%$term%' OR
        concat(`projects`.`projects_code`, '-', `tasks`.`tasks_count`) LIKE '%$term%' OR
        concat(`projects`.`projects_code`, '', `tasks`.`tasks_count`) LIKE '%$term%' OR
        concat(`projects`.`projects_code`, ' ', `tasks`.`tasks_count`) LIKE '%$term%'
    ) AND";

    // should probably do this as an array
    if (!empty($_POST['search_field2']) && !empty($_POST['search_term2'])) {
        $term2 = $_POST['search_term2'];
        $field2 = $_POST['search_field2'];
        $SQL = rtrim($SQL, ') AND');
        $SQL .= " OR `" . $field2 . "` LIKE '%$term2%') AND";
    }

    if (!empty($_POST['search_field3']) && !empty($_POST['search_term3'])) {
        $term3 = $_POST['search_term3'];
        $field3 = $_POST['search_field3'];
        $SQL = rtrim($SQL, ') AND');
        $SQL .= " OR `" . $field3 . "` LIKE '%$term3%') AND";
    }

    if (!empty($_POST['search_field4']) && !empty($_POST['search_term4'])) {
        $term4 = $_POST['search_term4'];
        $field4 = $_POST['search_field4'];
        $SQL = rtrim($SQL, ') AND');
        $SQL .= " OR `" . $field4 . "` LIKE '%$term4%') AND";
    }

    if (!empty($_POST['search_project'])) {
        $project = $_POST['search_project'];
        $SQL .= " `tasks_projects` = $project AND";
    }
 	
	// hide deleted if not admin
	if ($access !== '0' && !empty($_POST['deleted'])) {
		$SQL .= " (tasks_deleted <> 1 OR tasks_deleted IS NULL) AND";
	}

    $SQL = rtrim($SQL, ' AND');
    $SQL = rtrim($SQL, ' OR');

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

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        header("HTTP/1.0 404 Not Found", 404);
        die(json_encode(array('message' => 'No Tasks Found', 'code' => 404)));
    }

    foreach($result as $k=>$task) {
        $tasks_assignee = $task['tasks_assignee'];
        $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $tasks_assignee");
        $query -> execute();
        $assignee = $query->fetch(PDO::FETCH_ASSOC);
        $result[$k]['tasks_assignee'] = (empty($assignee) ? 'Unassigned' : $assignee);

        $tasks_reporter= $task['tasks_reporter'];
        $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $tasks_reporter");
        $query -> execute();
        $reporter = $query->fetch(PDO::FETCH_ASSOC);
        $result[$k]['tasks_reporter'] = (empty($reporter) ? 'Unassigned' : $reporter);

        $tasks_related = $task['tasks_related'];
        $query = $con->prepare("SELECT `tasks_id`, `tasks_title` FROM tasks WHERE `tasks_id` = $tasks_related");
        $query -> execute();
        $result[$k]['tasks_related'] = $query->fetch(PDO::FETCH_ASSOC);

        $projects_lead = $task['projects_lead'];
        $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $projects_lead");
        $query -> execute();
        $lead = $query->fetch(PDO::FETCH_ASSOC);
        $result[$k]['projects_lead'] = (empty($lead) ? 'Unassigned' : $lead);

        $projects_client = $task['projects_client'];
        $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $projects_client");
        $query -> execute();
        $client = $query->fetch(PDO::FETCH_ASSOC);
        $result[$k]['projects_client'] = (empty($client) ? 'Unassigned' : $client);

        $projects_manager = $task['projects_manager'];
        $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $projects_manager");
        $query -> execute();
        $manager = $query->fetch(PDO::FETCH_ASSOC);
        $result[$k]['projects_manager'] = (empty($manager) ? 'Unassigned' : $manager);

        $result[$k]['tasks_code'] = $task['projects_code'] . '-' . $task['tasks_count'];

        $result[$k]['tasks_deadline'] = showDate($task['tasks_deadline']);
        $result[$k]['tasks_created'] = showDate($task['tasks_created']);
        $result[$k]['tasks_updated'] = showDate($task['tasks_updated']);
    }

} else if ($_POST['search_type'] == 'projects') {

    $SQL = "SELECT * FROM projects WHERE";
    $SQL .= " `projects_name` LIKE '%$term%' OR `projects_code` LIKE '%$term%' AND";
 	
	// hide tasks if not admin
	if ($access !== '0') {
		$SQL .= " (projects_deleted <> 1 OR projects_deleted IS NULL) AND";
	}

    $SQL = rtrim($SQL, ' AND');
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

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        header("HTTP/1.0 404 Not Found", 404);
        die(json_encode(array('message' => 'No Projects Found', 'code' => 404)));
    }

    foreach($result as $k =>$project) {
        $project_lead = $project['projects_lead'];
        $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $project_lead");
        $query -> execute();
        $lead = $query->fetch(PDO::FETCH_ASSOC);
        $result[$k]['projects_lead'] = (empty($lead) ? "Unassigned" : $lead);

        $project_client = $project['projects_client'];
        $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $project_client");
        $query -> execute();
        $client = $query->fetch(PDO::FETCH_ASSOC);
        $result[$k]['projects_client'] = (empty($client) ? "Unassigned" : $lead);

        $project_manager = $project['projects_manager'];
        $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $project_manager");
        $query -> execute();
        $manager = $query->fetch(PDO::FETCH_ASSOC);
        $result[$k]['projects_manager'] = (empty($manager) ? "Unassigned" : $lead);
    }

} else if ($_POST['search_type'] == 'users') {

    $SQL = "SELECT * FROM users WHERE";
    $SQL .= " `users_name` LIKE '%$term%' OR `users_email` LIKE '%$term%'";

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

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        header("HTTP/1.0 404 Not Found", 404);
        die(json_encode(array('message' => 'No Users Found', 'code' => 404)));
    }

    foreach($result as $k => $user) {
        if (empty($user['users_image'])) {
            $result[$k]['users_image'] = get_gravatar($user['users_email']);
        }
    }


} else {
    $result = array(
	'code' => 400,
	'message' => 'Please specify search type'
    );
    header("HTTP/1.0 400 Bad Request", 400);
    if ($GLOBALS['environment']) {
        header('Query: ' . preg_replace("/\r|\n|\s/"," ",$SQL), false);
    }
    die(json_encode($result));
}

header('Content-Type: application/json');
if ($GLOBALS['environment']) {
    header('Query: ' . preg_replace("/\r|\n|\s/"," ",$SQL), false);
}
echo json_encode($result);