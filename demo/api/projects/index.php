<?php
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

	session_start();
	$access = $_SESSION['users_type'];

    $SQL = "SELECT * FROM projects WHERE";

    // Get specific project
    if (!empty($_POST['projects_id'])) {
        $projects_id = $_POST['projects_id'];
        $SQL .= " `projects_id` = $projects_id AND";
    }

    if (!empty($_POST['projects_lead'])) {
        $projects_lead = $_POST['projects_lead'];
        $SQL .= " `projects_lead` = $projects_lead AND";
    }

    if (!empty($_POST['projects_client'])) {
        $projects_client = $_POST['projects_client'];
        $SQL .= " `projects_client` = $projects_client AND";
    }
	
    if (!empty($_POST['projects_manager'])) {
        $projects_manager = $_POST['projects_manager'];
        $SQL .= " `projects_manager` = $projects_manager AND";
    }
	
	// hide deleted comments if not admin
	if ($access !== '0') {
		$SQL .= " (projects_deleted <> 1 OR projects_deleted IS NULL) AND";
	}

    $SQL = rtrim($SQL, ' AND');
    $SQL = rtrim($SQL, ' OR');
    $SQL = rtrim($SQL, ' WHERE');

    require($_SERVER['DOCUMENT_ROOT'] . '/api/default.php');

// for debugging
// echo $SQL;
// exit;

$query = $con->prepare($SQL);
$query -> execute();

if ($query->errorCode() !== "00000") {
    header("HTTP/1.0 400 Bad Request", 400);
    die(json_encode(array(message => 'Bad Request', code => 400)));
}

$projects = $query->fetchAll(PDO::FETCH_ASSOC);

if (empty($projects)) {
    header("HTTP/1.0 404 Not Found", 404);
    die(json_encode(array(message => 'No Projects Found', code => 404)));
}

foreach($projects as $k =>$project) {
    $project_lead = $project['projects_lead'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $project_lead");
    $query -> execute();
    $lead = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($lead['users_image'])) {
        $lead['users_image'] = get_gravatar($lead['users_email']);
    }
    $projects[$k]['projects_lead'] = (empty($lead) ? "Unassigned" : $lead);

    $project_client = $project['projects_client'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $project_client");
    $query -> execute();
    $client = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($client['users_image'])) {
        $client['users_image'] = get_gravatar($client['users_email']);
    }
    $projects[$k]['projects_client'] = (empty($client) ? "Unassigned" : $lead);
	
	$project_manager = $project['projects_manager'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $project_manager");
    $query -> execute();
    $manager = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($manager['users_image'])) {
        $manager['users_image'] = get_gravatar($manager['users_email']);
    }
    $projects[$k]['projects_manager'] = (empty($manager) ? "Unassigned" : $lead);
}

header('Content-Type: application/json');
echo json_encode($projects);