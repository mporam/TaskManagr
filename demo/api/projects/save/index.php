<?php
if (!empty($_POST)) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
        require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

	$name =  trim($_POST['projects_name']);
        $code =  $_POST['projects_code'];
        $desc =  trim($_POST['projects_desc']);
 	$lead =  $_POST['projects_lead'];
	$client = $_POST['projects_client'];
	$manager = $_POST['projects_manager'];
	$deleted = (empty($_POST['projects_deleted']) ? '0' : $_POST['projects_deleted']);

	if (!empty($_POST['projects_id'])) {
		$id = $_POST['projects_id'];
		$query = $con->prepare("UPDATE projects SET `projects_name`='$name', `projects_code`='$code', `projects_desc`='$desc', `projects_lead`=$lead, `projects_client`=$client, `projects_manager` = $manager, `projects_deleted`=$deleted WHERE `projects_id` = $id");
	} else {
		$query = $con->prepare("INSERT INTO projects (`projects_name`, `projects_code`, `projects_desc`, `projects_lead`, `projects_client`, `projects_manager`) VALUES ('$name', '$code', '$desc', $lead, $client, $manager)");
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
	
	if (empty($_POST['projects_id'])) {
		$lastid = $con->lastInsertId();
	} else {
		$lastid = $_POST['projects_id'];
	}
	$result = array(
		code => 200,
		message => 'Project Saved',
		id => $lastid
	);
	
	echo json_encode($result);

} else {
	die(json_encode(array(message => 'Internal Server Error', code => 500)));
}