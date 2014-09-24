<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<script>
    <?php if (!empty($_GET['code'])) echo "data.projects_code = '" . $_GET['code'] . "'"; ?>
</script>
<script src="/js/projects/core.js"></script>
<title>Projects</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
    
    <div id="projects">
        <span class="load">Loading...</span>
    </div>
    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>
