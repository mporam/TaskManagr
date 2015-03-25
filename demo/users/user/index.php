<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<?php $GLOBALS['js']->addScript('users/user.js'); ?>

<?php
    if (empty($_GET['name'])) {
        header('Location: /users/');
        exit;
    }?>
    <title>Admin</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
<h3>User</h3>

<div id="user">
    <img src="/images/site/icons/loading.gif" class="loader">
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>