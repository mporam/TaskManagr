<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/includes/verify.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/head_default.php'); ?>
    <script> var get = {};
        <?php if(!empty($_GET)) {
        foreach($_GET as $k => $v) {
            if (!empty($v)) echo "get." . $k . " = '" . $v . "';";
        } } ?>
    </script>