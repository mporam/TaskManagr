<?php
if (!empty($_POST)) {
    session_start();
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
        
	$user    = $_POST['comments_user'];
    $access  =  ($_POST['comments_access'] >= $_SESSION['users_type_id'] ? $_POST['comments_access'] : $_SESSION['users_type_id']);
    $comment =  trim($_POST['comments_comment']);
 	$task    =  $_POST['comments_task_id'];
	$deleted = (empty($_POST['comments_deleted']) ? '0' : $_POST['comments_deleted']);

	if (!empty($_POST['comments_id'])) {
		$id = $_POST['comments_id'];
		$query = $con->prepare("UPDATE comments SET `comments_user`=$user, `comments_access`=$access, `comments_comment`='$comment', `comments_task_id`=$task, `comments_deleted`=$deleted WHERE `comments_id` = $id");
	} else {
		$query = $con->prepare("INSERT INTO comments (`comments_user`, `comments_access`, `comments_comment`, `comments_task_id`, `comments_added`) VALUES ($user, $access, '$comment', $task, NOW())");
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
	
	if (empty($_POST['comments_id'])) {
		$lastid = $con->lastInsertId();
	} else {
		$lastid = $_POST['comments_id'];
	}
	$result = array(
		'code' => 200,
		'message' => 'Comment Saved',
		'id' => $lastid
	);

    header('Content-Type: application/json');
    if ($env) {
        header('Query: ' . preg_replace("/\r|\n|\s/"," ",$SQL), false);
    }
	echo json_encode($result);

} else {
    header("HTTP/1.0 400 Bad Request", 400);
	die(json_encode(array('message' => 'Incomplete data', 'code' => 400)));
}