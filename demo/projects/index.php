<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<script>
    <?php if (!empty($_GET['code'])) echo "data.projects_code = '" . $_GET['code'] . "'"; ?>
</script>
<?php $GLOBALS['js']->addScript('libraries/jquery.circliful.min.js'); ?>
<?php $GLOBALS['js']->addScript('projects/core.js'); ?>
<title>Projects</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>

    <div id="projects">
        <h3>Projects</h3>

        <div class="grid"></div>

        <img src="/images/site/icons/loading.gif" class="loader">
    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>
