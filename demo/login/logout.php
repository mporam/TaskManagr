<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
session_start();
session_destroy();
unset($_COOKIE['taskManagr']);
setcookie('taskManagr', null, -1, '/');
header("Location: /login/");