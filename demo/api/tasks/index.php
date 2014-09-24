<?php
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
	
	session_start();
	$access = $_SESSION['users_type'];
    
    $SQL = "SELECT * FROM tasks";
    
    if (!empty($_POST['count']) && $_POST['count']) {
        $SQL = "SELECT COUNT(*) FROM tasks";
    }
    
    $SQL .= "
    LEFT JOIN tasks_type 
        ON tasks.tasks_type = tasks_type.tasks_type_id
    LEFT JOIN tasks_status
        ON tasks.tasks_status = tasks_status.tasks_status_id
    LEFT JOIN tasks_priority
        ON tasks.tasks_priority = tasks_priority.tasks_priority_id
    LEFT JOIN projects
        ON tasks.tasks_projects = projects.projects_id 
    WHERE";

    // Get specific task by id
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

    // Get specific task by count num
    if (!empty($_POST['tasks_count']) && strpos($_POST['tasks_count'],',') === false) {
        $tasks_count = $_POST['tasks_count'];
        $SQL .= " `tasks_count` = $tasks_count AND";
    } else if 
        (!empty($_POST['tasks_count']) && strpos($_POST['tasks_count'],',') !== false) {
            $task_counts = explode(',', $_POST['tasks_count']);
            foreach($task_counts as $task_count) {
                $SQL .= " `tasks_count` = $task_count OR";
            }
            $SQL = rtrim($SQL, ' OR');
            $SQL .= " AND";
    }

    if (!empty($_POST['projects_code'])) {
        $project_code = $_POST['projects_code'];
        $SQL .= " projects.projects_code = '$project_code' AND";
    }

    if (!empty($_POST['projects_id'])) {
        $project_id = $_POST['projects_id'];
        $SQL .= " tasks_projects = $project_id AND";
    }

    if (!empty($_POST['projects_client'])) {
        $project_client = $_POST['projects_client'];
        $SQL .= " projects.projects_client = $project_client AND";
    }

    if (!empty($_POST['tasks_type'])) {
        $task_type = $_POST['tasks_type'];
        $SQL .= " tasks_type_id = $task_type AND";
    }

    if (!empty($_POST['tasks_status']) && strpos($_POST['tasks_status'],',') === false) {
        $task_status = $_POST['tasks_status'];
        $SQL .= " tasks_status_id = $task_status AND";
    } else if (!empty($_POST['tasks_status']) && strpos($_POST['tasks_status'],',') !== false) {
        $task_status = explode(',', $_POST['tasks_status']);
        foreach($task_status as $status) {
            $SQL .= " `tasks_status_id` = $status OR";
        }
        $SQL = rtrim($SQL, ' OR');
        $SQL .= " AND";
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
		$SQL .= " (tasks_deleted <> 1 OR tasks_deleted IS NULL) AND";
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

if ($query->errorCode() !== "00000") {
    header("HTTP/1.0 400 Bad Request", 400);
    die(json_encode(array('message' => 'Bad Request', 'code' => 400)));
}

if (!empty($_POST['count']) && $_POST['count']) {
    $tasks = $query->fetchColumn(); 
    header('Content-Type: application/json');
    echo json_encode($tasks);
    exit;
}

$tasks = $query->fetchAll(PDO::FETCH_ASSOC);

if (empty($tasks)) {
    header("HTTP/1.0 404 Not Found", 404);
    die(json_encode(array('message' => 'No Tasks Found', 'code' => 404)));
}

foreach($tasks as $k=>$task) {
    $tasks_assignee = $task['tasks_assignee'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $tasks_assignee");
    $query -> execute();
    $assignee = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($assignee['users_image'])) {
        $assignee['users_image'] = get_gravatar($assignee['users_email']);
    }
    $tasks[$k]['tasks_assignee'] = (empty($assignee) ? 'Unassigned' : $assignee);

    $tasks_reporter= $task['tasks_reporter'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $tasks_reporter");
    $query -> execute();
    $reporter = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($reporter['users_image'])) {
        $reporter['users_image'] = get_gravatar($reporter['users_email']);
    }
    $tasks[$k]['tasks_reporter'] = (empty($reporter) ? 'Unassigned' : $reporter);

    $tasks_related = $task['tasks_related'];
    $query = $con->prepare("SELECT `tasks_id`, `tasks_title` FROM tasks WHERE `tasks_id` = $tasks_related");
    $query -> execute();
    $tasks[$k]['tasks_related'] = $query->fetch(PDO::FETCH_ASSOC);

    $projects_lead = $task['projects_lead'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $projects_lead");
    $query -> execute();
    $lead = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($lead['users_image'])) {
        $lead['users_image'] = get_gravatar($lead['users_email']);
    }
    $tasks[$k]['projects_lead'] = (empty($lead) ? 'Unassigned' : $lead);

    $projects_client = $task['projects_client'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $projects_client");
    $query -> execute();
    $client = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($client['users_image'])) {
        $client['users_image'] = get_gravatar($client['users_email']);
    }
    $tasks[$k]['projects_client'] = (empty($client) ? 'Unassigned' : $client);
	
    $projects_manager = $task['projects_manager'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $projects_manager");
    $query -> execute();
    $manager = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($manager['users_image'])) {
        $manager['users_image'] = get_gravatar($manager['users_email']);
    }
    $tasks[$k]['projects_manager'] = (empty($manager) ? 'Unassigned' : $manager);
    
    $tasks[$k]['tasks_code'] = $task['projects_code'] . '-' . $task['tasks_count'];
    
    $tasks[$k]['tasks_deadline'] = showDate($task['tasks_deadline']);
    $tasks[$k]['tasks_created'] = showDate($task['tasks_created']);
    $tasks[$k]['tasks_updated'] = showDate($task['tasks_updated']);
}

header('Content-Type: application/json');
if ($env) {
    header('Query: ' . preg_replace("/\r|\n|\s/"," ",$SQL), false);
}
echo json_encode($tasks);