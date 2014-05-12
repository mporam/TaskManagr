<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
    <script src="/js/projects/new.js"></script>
    <title>Projects</title>
</head>
<body>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
    <h3>Create New Project</h3>
    <form>
        <div>
            <label for="projects_name">Name*</label>
            <input type="text" name="projects_name" id="projects_name" required />
        </div>
        <div>
            <label for="projects_code">Shortcode*</label>
            <input type="text" name="projects_code" id="projects_code" required />
        </div>
        <div>
            <label for="projects_desc">Description</label>
            <textarea name="projects_desc" id="projects_desc"></textarea>
        </div>
        <div>
            <label for="projects_lead">Project Lead</label>
            <select name="projects_lead" id="projects_lead">
                <option value="<?php echo $_SESSION['users_id']; ?>">Current User - <?php echo $_SESSION['users_name']; ?></option>
            </select>
        </div>
        <div>
            <label for="projects_client">Project Client</label>
            <select name="projects_client" id="projects_client">
                <option value="0">In-house</option>
            </select>
        </div>
        <div>
            <label for="projects_manager">Project Manager*</label>
            <select name="projects_manager" id="projects_client" required>
                <option value="<?php echo $_SESSION['users_id']; ?>">Current User - <?php echo $_SESSION['users_name']; ?></option>
            </select>
        </div>
        <p>* - required fields</p>
        <div>
            <input type="submit" value="Create" />
        </div>
    </form>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>