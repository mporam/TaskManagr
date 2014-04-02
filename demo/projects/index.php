<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<script>
    <?php if (!empty($_GET['code'])) echo "data.projects_code = '" . $_GET['code'] . "'"; ?>
</script>
<script src="/js/projects.js"></script>
<title>Projects</title>
</head>
<body>
    <div id="projects">
        <span class="load">Loading...</span>
        <table width="100%">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Project Lead</th>
                    <th>Project Manager</th>
                    <th>Client</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>
