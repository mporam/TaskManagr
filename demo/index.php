<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<?php $GLOBALS['js']->addScript('dashboard/core.js'); ?>
    <title>Admin</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
    
    <h2>Dashboard</h2>

    <?php $module->show('inprogress', 8); ?>

    <?php $module->show('stats', 4); ?>

    <?php $module->show('mytasks', 8); ?>

    <?php $module->show('recenttasks', 4); ?>

    <?php $module->show('taskupdate', 4); ?>


<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>
