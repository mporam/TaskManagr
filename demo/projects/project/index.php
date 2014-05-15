<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<script src="/js/projects/project.js"></script>

<?php
    if (empty($_GET['project'])) {
        header('Location: /projects/');
        exit;
    } ?>
    <title>Admin</title>
</head>
<body>    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
<h2>Project</h2>

<div id="project">

</div>

<div id="tasks">
    
</div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>