<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<script>
    <?php if (!empty($_GET['name'])) echo "data.users_name = '" . $_GET['name'] . "'"; ?>
</script>
<script src="/js/users.js"></script>
<title>Users</title>
</head>
<body>
    <div id="users">
        <span class="load">Loading...</span>
    </div>
    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>
