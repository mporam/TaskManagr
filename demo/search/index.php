<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<?php $GLOBALS['js']->addScript('search/core.js'); ?>
    <title>Search</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>

<div id="search">

    <div>
        <h2>Advanced Search Results</h2>

        <form method="GET" action="/search/">
            <input type="search" value="<?php echo (!empty($_GET['term']) ? $_GET['term'] : ''); ?>" placeholder="search&hellip;" name="term">
            <input type="submit" value="Search">
        </form>

        <?php $module->filterBy(); ?>
        <?php $module->orderBy(); ?>
    </div>


    <h2>Tasks</h2>
    <div id="task-results"></div>

    <h2>Projects</h2>
    <div id="project-results"></div>

    <h2>Users</h2>
    <div id="user-results"></div>
    
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?> 