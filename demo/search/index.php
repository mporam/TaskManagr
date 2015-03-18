<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<?php $GLOBALS['js']->addScript('search/core.js'); ?>
    <title>Search</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>

<h2>Search Results</h2>

<div id="search">

    <form method="GET" action="/search/">
        <input type="search" value="<?php echo $_GET['term']; ?>" placeholder="search&hellip;" name="term">
        <input type="submit" value="Search">
    </form>
    
    
    <div id="task-results">
        <h3>Tasks:</h3>
    </div>
    
    <div id="project-results">
        <h3>Projects:</h3>
    </div>
    
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?> 