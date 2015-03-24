<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php');
$GLOBALS['js']->addScript('projects/project.js');

    if (empty($_GET['project'])) {
        header('Location: /projects/');
        exit;
    }
?>
<title>Admin</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
<h2>Project</h2>

<div id="project">
    <img src="/images/site/icons/loading.gif" class="loader">
</div>

<div id="tasks">
    <h3>Tasks</h3>
    <img src="/images/site/icons/loading.gif" class="loader">
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>