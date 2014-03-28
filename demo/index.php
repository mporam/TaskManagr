<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/includes/verify.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/head_default.php'); ?>
<title>Admin</title>
</head>
<body>
<?php var_dump($_SESSION); ?>
</body>
</html>