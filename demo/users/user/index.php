<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<script src="/js/users/user.js"></script>

<?php
    if (empty($_GET['name'])) {
        header('Location: /users/');
        exit;
    }?>
    <title>Admin</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
<h3>User</h3>

<div id="user">
Loading...
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>