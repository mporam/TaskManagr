<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<?php $GLOBALS['js']->addScript("users/core.js"); ?>
    <title>Users</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
    <div id="users">
        <table width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Access Level</th>
                <th>Image</th>
            </tr>
            </thead>
            <tbody>
                <img src="/images/site/icons/loading.gif" class="loader">
            </tbody>
        </table>
    </div>
    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>
