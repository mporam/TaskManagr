<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<script src="/js/tasks/task.js"></script>

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
Loading...
</div>
<div id="comments">
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