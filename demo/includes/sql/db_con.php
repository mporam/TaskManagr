<?php
$env = 'local';
if ($_SERVER['SERVER_NAME'] == 'demo.taskmanagr.co.uk') {
    $env = 'production';
} else if (
	$_SERVER['SERVER_NAME'] == 'staging.taskmanagr.co.uk' ||
	$_SERVER['SERVER_NAME'] == 'mike.taskmanagr.co.uk' ||
	$_SERVER['SERVER_NAME'] == 'hannah.taskmanagr.co.uk' ||
	$_SERVER['SERVER_NAME'] == 'max.taskmanagr.co.uk'
) {
    $env = 'staging';
}

/* Connect to an ODBC database using driver invocation */
if ($env == 'production') {
	// turn off error reporting 
	error_reporting(0);
	$dsn = 'mysql:dbname=taskmana_db;host=10.168.1.50';
} else if ($env == 'staging') {
    error_reporting(E_ALL);
    $dsn = 'mysql:dbname=taskmana_staging_db;host=10.168.1.49';
} else {
	$dsn = 'mysql:dbname=taskmana_staging_db;host=91.208.99.2:3349';
}
$user = 'taskmana_db';
$password = 'Pa55word';

try {
	$con = new PDO($dsn, $user, $password);
	$con->setAttribute( \PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    if ($_SERVER['SERVER_NAME'] == 'demo.taskmanagr.co.uk') {
        // live error message
        echo '<p>Error connecting to Task Managr database, please check the settings in your config file</p>';
    } else {
        // dev error message
        echo '<p>Database connection failed, please enable remote access</p>';
        echo '<p>If that doesnt work, give this geeky error to Mike: ' . $e->getMessage() . '</p>';
    }
}
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);