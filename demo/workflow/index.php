<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<?php $GLOBALS['js']->addScript("workflow/core.js"); ?>
    <title>Admin</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>

<div id="workflow">
    <h2>Workflow</h2>
    <div class="grid" id="workflow-titles"></div>
    <div class="grid" id="workflow-tasks"></div>
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>