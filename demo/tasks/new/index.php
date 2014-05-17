<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/js/ckeditor/adapters/jquery.js"></script>
    <script src="/js/tasks/new.js"></script>
    <title>Admin</title>
</head>
<body>    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
    <h3>Create New Task</h3>
    <form>
        <div>
            <label for="tasks_projects">Project*</label>
            <select name="tasks_projects" id="tasks_projects" required>
                <option></option>
            </select>
        </div>
        <div>
            <label for="tasks_name">Task Name*</label>
            <input type="text" name="tasks_name" id="tasks_name" required />
        </div>
        <div>
            <label for="tasks_type">Type*</label>
            <select name="tasks_type" id="tasks_type" required>
                <option></option>
            </select>
        </div>
        <div>
            <label for="tasks_assignee">Assignee*</label>
            <select name=tasks_assignee" id="tasks_assignee" required>
                <option value="<?php echo $_SESSION['users_id']; ?>">Current User - <?php echo $_SESSION['users_name']; ?></option>
            </select>
        </div>
        <div>
            <label for="tasks_reporter">Reporter*</label>
            <select name=tasks_reporter" id="tasks_reporter" required>
                <option value="<?php echo $_SESSION['users_id']; ?>">Current User - <?php echo $_SESSION['users_name']; ?></option>
            </select>
        </div>
        <div>
            <label for="tasks_desc">Description</label>
            <textarea name="tasks_desc" id="tasks_desc"></textarea>
            <?php // need to initiate the CKEditor for this ?>
        </div>
        <div>
            <label for="tasks_priority">Priority*</label>
            <select name=tasks_priority" id="tasks_priority" required>
            </select>
        </div>
        <div>
            <label for="tasks_deadline">Deadline</label>
            <input type="date" name="tasks_deadline" id="tasks_deadline" placeholder="YYYY-MM-DD" />
            <?php // I suggest using a datepicker plugin for this ?>
        </div>
        <div>
            <label for="tasks_related">Related to</label>
            <input type="text" name="tasks_related" id="tasks_related" />
            <ul id="related">
            </ul>
        </div>
        <p>* - required fields</p>
        <div>
            <input type="submit" value="Create" />
        </div>
    </form>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?> 