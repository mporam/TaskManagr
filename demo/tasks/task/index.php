<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<script src="/js/tasks/task.js"></script>

<?php
    if (empty($_GET['task'])) {
        header('Location: /tasks/');
        exit;
    } else { ?>
        <script>
        var get = {};
        get.task = "<?php echo $_GET['task']; ?>";
        get.projects_code = get.task.split("-")[0];
        get.tasks_count = get.task.split("-")[1];
        </script>
<?php } ?>
    <title>Admin</title>
</head>
<body>    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
<h3>Task</h3>

<div id="task">
Loading...
</div>
<div id="comments">
    <form>
        <textarea name="comment" id="comment" required></textarea>
        <input type="submit" value="Add">
    </form>
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?> 