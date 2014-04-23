<?php
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

	session_start();
	$access = $_SESSION['users_tasks'];

    $SQL = "SELECT * FROM comments WHERE";

    if (!empty($_POST['comments_access'])) {
        $comments_access = $_POST['comments_access'];
        $SQL .= " `comments_access` <= $comments_access AND";
    }

    if (!empty($_POST['comments_task_id'])) {
        $comments_task_id = $_POST['comments_task_id'];
        $SQL .= " `comments_task_id` = $comments_task_id AND";
    }
	
	// hide tasks if not admin
	if ($access !== '0') {
		$SQL .= " (comments_deleted <> 1 OR comments_deleted IS NULL) AND";
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
$comments = $query->fetchAll(PDO::FETCH_ASSOC);

foreach($comments as $k =>$comment) {
    $comment_user = $comment['comments_user'];
    $query = $con->prepare("SELECT * FROM users WHERE `users_id` = $comment_user");
    $query -> execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
    $comments[$k]['comment_user'] = (empty($user) ? 'Unassigned' : $user);
}

header('Content-Type: application/json');
echo json_encode($comments);