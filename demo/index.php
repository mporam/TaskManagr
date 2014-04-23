<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/includes/verify.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/head_default.php'); ?>
    <script src="/js/dashboard/core.js" type="text/javascript"></script>
    <title>Admin</title>
</head>
<body>    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>

    <?php var_dump($_SESSION); ?>

    <div id="inprogress">
        <table>
        </table>
    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?> 
