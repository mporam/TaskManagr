<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
session_start();
if(!empty($_POST['user_email']) && !empty($_POST['user_password']) && !empty($_GET['loc'])) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');

    $loc = $_GET['loc'];

    $email= $_POST['user_email'];
    $password = $_POST['user_password'];

    $query = $con->prepare("SELECT `users_salt` FROM users WHERE `users_email` = '$email'");
    $query -> execute();
    $salt = $query->fetchColumn();

    if (empty($salt)) {
        session_destroy();
	header("Location: /login/?login=failed");
        exit;
    }
    $password = sha1($password . $salt);

    $query = $con->prepare("SELECT * FROM users LEFT JOIN users_type ON users.users_type = users_type.users_type_id WHERE `users_email` = '$email' AND `users_password` = '$password'");
    $query -> execute();
    $_SESSION = $query->fetch(PDO::FETCH_ASSOC);

    if (empty($_SESSION)) {
		session_destroy();
		header("Location: /login/?login=failed");
                exit;
    }

    $_SESSION['KCFINDER'] = array();
    $_SESSION['KCFINDER']['disabled'] = false;

    if ($_POST['remember']) {
        $value = array(
            'email' => $_SESSION['users_email'],
            'password' => $_SESSION['users_password']
        );
	$expiry = time()+(365 * 24 * 60 * 60);
        setcookie("taskManagr", json_encode($value), $expiry, '/');
    }

    header("Location: " . $loc);
} else {
	session_destroy();
	header("Location: /login/?login=false");
}