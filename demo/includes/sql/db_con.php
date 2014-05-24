<?php
$env = 'local';
if ($_SERVER['SERVER_NAME'] == 'demo.taskmanagr.co.uk') {
    $env = 'production';
} else if ($_SERVER['SERVER_NAME'] == 'staging.taskmanagr.co.uk') {
    $env = 'staging';
}

/* Connect to an ODBC database using driver invocation */
if ($env == 'production') {
	// turn off error reporting 
	error_reporting(0);
	$dsn = 'mysql:dbname=taskmana_db;host=10.168.1.50';
} else if ($env == 'staging') {
    error_reporting(E_ALL);
    $dsn = 'mysql:dbname=taskmana_db;host=10.168.1.50';
} else {
	$dsn = 'mysql:dbname=taskmana_db;host=91.208.99.2:3350';
}
$user = 'taskmana_db';
$password = 'Pa55word';

try {
	$con = new PDO($dsn, $user, $password);
	$con->setAttribute( \PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);