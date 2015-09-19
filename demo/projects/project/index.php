<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php');
$GLOBALS['js']->addScript('projects/project.js');

    if (empty($_GET['project'])) {
        header('Location: /projects/');
        exit;
    }
?>
<title>Admin</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>

<div id="project">
    <div class="tabs">
    </div>
    <div class="tab-content">
        <div data-id="overview" class="open">
            <img src="/images/site/icons/loading.gif" class="loader">
        </div>

        <div data-id="tasks">
            <div class="clearfix">
                <div class="right">
                    <?php $module->filterBy(); ?>
                    <?php $module->orderBy(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>