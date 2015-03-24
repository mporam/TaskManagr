<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
<script>
    <?php if (!empty($_GET['code'])) echo "data.projects_code = '" . $_GET['code'] . "'"; ?>
</script>
<?php $GLOBALS['js']->addScript('projects/core.js'); ?>
<title>Projects</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>

    <div id="projects">
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Project Lead</th>
                    <th>Project Manager</th>
                    <th>Client</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <img src="/images/site/icons/loading.gif" class="loader">
    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>
