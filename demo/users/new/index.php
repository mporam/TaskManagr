<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
    <script src="/js/users/new.js"></script>
    <title>Users</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
<h3>Create New User</h3>
<form>
	<div>
		<label for="users_name">Name</label>
        <input type="text" name="users_name" id="users_name" />
	</div>
	<div>
		<label for="users_email">Email</label>
        <input type="text" name="users_email" id="users_email" />
	</div>
	<div>
		<label for="users_type">User Type</label>
        <select name="users_type" id="users_type">
        </select>
        <a href="#">What is this?</a>
	</div>
	<div>
        <input type="submit" value="Create" />
	</div>
</form>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>
