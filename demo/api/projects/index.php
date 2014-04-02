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
    
    if (!empty($_POST['projects_code'])) {
        $projects_code = $_POST['projects_code'];
        $SQL .= " `projects_code` = '$projects_code' AND";
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
		$SQL .= " projects_deleted <> 1 AND";
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
$projects = $query->fetchAll(PDO::FETCH_ASSOC);

foreach($projects as $k =>$project) {
    $project_lead = $project['projects_lead'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $project_lead");
    $query -> execute();
    $lead = $query->fetch(PDO::FETCH_ASSOC);
    $projects[$k]['projects_lead'] = (empty($lead) ? "Unassigned" : $lead);

    $project_client = $project['projects_client'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $project_client");
    $query -> execute();
    $client = $query->fetch(PDO::FETCH_ASSOC);
    $projects[$k]['projects_client'] = (empty($client) ? "Unassigned" : $lead);
	
	$project_manager = $project['projects_manager'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $project_manager");
    $query -> execute();
    $manager = $query->fetch(PDO::FETCH_ASSOC);
    $projects[$k]['projects_manager'] = (empty($manager) ? "Unassigned" : $lead);
}

header('Content-Type: application/json');
echo json_encode($projects);