<?php 
$request = $_SERVER['REQUEST_URI'];

session_start();
if(empty($_SESSION)) {
    session_destroy();
    header("Location: /login/?referrer=" . $request);
}

$email = $_SESSION['users_email'];
$password = $_SESSION['users_password'];

$query = $con->prepare("SELECT * FROM users WHERE `users_email` = '$email' AND `users_password` = '$password'");
$query -> execute();
$check = $query->fetch(PDO::FETCH_ASSOC);

if (empty($check)) {
    session_destroy();
    header("Location: /login/?login=failed&referrer=" . $request);
} else {
    $_SESSION['KCFINDER'] = array();
    $_SESSION['KCFINDER']['disabled'] = false;
}