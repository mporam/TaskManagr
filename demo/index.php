<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
    <script src="/js/dashboard/core.js" type="text/javascript"></script>
    <title>Admin</title>
</head>
<body>    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>

    <?php var_dump($_SESSION); ?>

    <div id="inprogress">
        <table>
        </table>
    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?> 
