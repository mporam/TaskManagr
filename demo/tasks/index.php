<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<?php $GLOBALS['js']->addScript('tasks/core.js'); ?>
    <title>Admin</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
    <?php
    var_dump($_SESSION);
    ?>

<h3>Tasks</h3>
<div id="tasks">
    <img src="/images/site/icons/loading.gif" class="loader">
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?> 