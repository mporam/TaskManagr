<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<?php $GLOBALS['js']->addScript('tasks/task.js'); ?>
<?php
    if (empty($_GET['task'])) {
        header('Location: /tasks/');
        exit;
    } ?>
    <title>Admin</title>
</head>
<body>    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
<h3>Task</h3>

<div id="task">
    <img src="/images/site/icons/loading.gif" class="loader">
</div>

<div id="comments">
    <h3>Comments</h3>
    <img src="/images/site/icons/loading.gif" class="loader">
</div>

<h4>Say something&hellip;</h4>
<form id="comment-form">
    <div>
        <textarea name="comment" id="comment" required></textarea>
    </div>
    <?php if ($_SESSION['users_type_id'] < 4) { ?>
    <div>
        <label>User Access:</label>
        <select name="access">
            <option value="3" selected>Private</option>
            <option value="4">Public</option>
        </select>
    </div> <?php } ?>
    <input type="submit" value="Add">
</form>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>