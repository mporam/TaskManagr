<?php
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/verify.php');


$query = $con->prepare("SELECT * FROM tasks_priority ORDER BY tasks_priority_id ASC");
$query -> execute();
$tasks_priority = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $con->prepare("SELECT * FROM tasks_status ORDER BY tasks_status_id ASC");
$query -> execute();
$tasks_status = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $con->prepare("SELECT * FROM tasks_type ORDER BY tasks_type_id ASC");
$query -> execute();
$tasks_type = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $con->prepare("SELECT * FROM users_type");
$query -> execute();
$users_type = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
<head>
   <script src="/js/libraries/jquery-1.10.1.min.js"></script>

<script>
$(function() {
var data = {};

 $('#api').children().first().prop('selected', true);

    $('#api').change(function() {
        $('.api-type').hide();
        $('[data-id="' + $(this).val() + '"]').show();
		data = {};
    });

    $('form').on('submit', function(e) {
    e.preventDefault();
    var url = $('#api').val();

    if (url == '/api/tasks/') {
        data.tasks_id = $('[data-id="' + url + '"] #tasks_id').val();
        data.projects_id = $('[data-id="' + url + '"] #projects_id').val();
        data.tasks_type = $('[data-id="' + url + '"] #tasks_type').val();
        data.tasks_priority = $('[data-id="' + url + '"] #tasks_priority').val();
        data.tasks_status = $('[data-id="' + url + '"] #tasks_status').val();
        data.tasks_assignee = $('[data-id="' + url + '"] #tasks_assignee').val();
        data.tasks_reporter = $('[data-id="' + url + '"] #tasks_reporter').val();
		data.tasks_related = $('[data-id="' + url + '"] #tasks_related').val();
        data.tasks_deadline_start = $('[data-id="' + url + '"] #tasks_deadline_start').val();
        data.tasks_deadline = $('[data-id="' + url + '"] #tasks_deadline').val();
    }

    if (url == '/api/projects/') {
        data.projects_id = $('[data-id="' + url + '"] #projects_id').val();
        data.projects_lead = $('[data-id="' + url + '"] #projects_lead').val();
        data.projects_client = $('[data-id="' + url + '"] #projects_client').val();
		data.projects_manager = $('[data-id="' + url + '"] #projects_manager').val();
    }

    if (url == '/api/users/') {
        data.users_id = $('[data-id="' + url + '"] #users_id').val();
        data.users_type = $('[data-id="' + url + '"] #users_type').val();
    }

    if (url == '/api/comments/') {
        data.comments_task_id = $('[data-id="' + url + '"] #comments_task_id').val();
        data.comments_access = $('[data-id="' + url + '"] #comments_access').val();
    }

    if (url == '/api/search/') {
        data.search_type = $('[data-id="' + url + '"] #search_type').val();
        data.search_term = $('[data-id="' + url + '"] #search_term').val();
    }

    data.order = $('#order').val();
    data.limit = $('#limit').val();

    $('#post code').html(JSON.stringify(data, null, '  '));

    $('#url').html(url);

    $.ajax({
    type: "POST",
    url: url,
    data: data,
    success: function(data, textStatus, jqXHR) {
    $('#result code').html(JSON.stringify(data, null, ' '));
},
    error: function(data, textStatus, jqXHR) {
        $('#result code').html(JSON.stringify(data.responseText, null, ' '));
    }
    });
    });
});
</script>
<style>
.api-type {
    display: none;
}

label {
display: block;
margin-top: 10px;
}
</style>
<title>TaskManagr API</title>
</head>
<body>
<form>
    <div>
        <label>API</label>
        <select name="api" id="api">
            <option selected>Please select</option>
            <option value="/api/projects/">Projects</option>
            <option value="/api/tasks/">Tasks</option>
            <option value="/api/users/">Users</option>
            <option value="/api/comments/">Comments</option>
            <option value="/api/search/">Search</option>
        </select>
    </div>

<div class="api-type" data-id="/api/projects/">
    <div>
        <label>Project ID (accepts only 1 ID)</label>
        <input type="text" name="projects_id" id="projects_id">
    </div>
    <div>
        <label>Project Lead (user ID)</label>
        <input type="text" name="projects_lead" id="projects_lead">
    </div>
    <div>
        <label>Project Client (user ID)</label>
        <input type="text" name="projects_client" id="projects_client">
    </div>
    <div>
        <label>Project Manager (user ID)</label>
        <input type="text" name="projects_manager" id="projects_manager">
    </div>
</div>

<div class="api-type" data-id="/api/tasks/">
    <div>
        <label>Task ID (seperate with , but no spaces)</label>
        <input type="text" name="tasks_id" id="tasks_id">
    </div>
    <div>
        <label>Project ID</label>
        <input type="text" name="projects_id" id="projects_id">
    </div>
    <div>
        <label>Task Type</label>
        <select name="tasks_type" id="tasks_type">
            <option value="">All</option>
            <?php
                  foreach($tasks_type as $type) {
                      echo "<option value='" . $type['tasks_type_id'] . "'>" . $type['tasks_type'] . "</option>";
                  }
             ?>
        </select>
    </div>
    <div>
        <label>Task Status</label>
        <select name="tasks_status" id="tasks_status">
            <option value="">All</option>
            <?php
                  foreach($tasks_status as $status) {
                      echo "<option value='" . $status['tasks_status_id'] . "'>" . $status['tasks_status'] . "</option>";
                  }
             ?>
        </select>
    </div>
   <div>
        <label>Task Priority</label>
        <select name="tasks_priority" id="tasks_priority">
            <option value="">All</option>
            <?php
                  foreach($tasks_priority as $priority) {
                      echo "<option value='" . $priority['tasks_priority_id'] . "'>" . $priority['tasks_priority'] . "</option>";
                  }
             ?>
        </select>
    </div>
    <div>
        <label>Task Assignee (user ID)</label>
        <input type="text" name="tasks_assignee" id="tasks_assignee">
    </div>
    <div>
        <label>Task Reporter (user ID)</label>
        <input type="text" name="tasks_reporter" id="tasks_reporter">
    </div>
    <div>
        <label>Task Reporter (user ID)</label>
        <input type="text" name="tasks_related" id="tasks_related">
    </div>
    <div>
        <label>Task Deadline Start (YYYY-MM-DD)</label>
        <input type="text" name="tasks_deadline_start" id="tasks_deadline_start">
    </div>
    <div>
        <label>Task Deadline (YYYY-MM-DD)</label>
        <input type="text" name="tasks_deadline" id="tasks_deadline">
    </div>
</div>

<div class="api-type" data-id="/api/users/">
    <div>
        <label>Users ID (accepts only 1 ID)</label>
        <input type="text" name="users_id" id="users_id">
    </div>
    <div>
        <label>Users Type</label>
        <select name="users_type" id="users_type">
            <option value="">All</option>
             <?php
                  foreach($users_type as $type) {
                      echo "<option value='" . $type['users_type_id'] . "'>" . $type['users_type_id'] . "</option>";
                  }
             ?>
        </select>
    </div>
</div>

<div class="api-type" data-id="/api/comments/">
    <div>
        <label>Task ID (accepts only 1 ID)</label>
        <input type="text" name="comments_task_id" id="comments_task_id">
    </div>
    <div>
        <label>Users Access</label>
        <select name="comments_access" id="comments_access">
            <option value="">All</option>
             <?php
                  foreach($users_type as $type) {
                      echo "<option value='" . $type['users_type_id'] . "'>" . $type['users_type'] . "</option>";
                  }
             ?>
        </select>
    </div>
</div>

<div class="api-type" data-id="/api/search/">
    <div>
        <label>Search Type</label>
        <select name="search_type" id="search_type">
             <option value="tasks">Tasks</option>
             <option value="projects">Projects</option>
        </select>
    </div>
    <div>
        <label>Search Term</label>
        <input type="text" name="search_term" id="search_term">
    </div>
</div>

    <div>
        <label>Order</label>
        <input type="text" name="order" id="order">
    </div>
    <div>
        <label>Limit</label>
        <input type="text" name="limit" id="limit">
    </div>
    <div>
        <input type="submit" value="Send Request">
    </div>
</form>

<h3>Data posted</h3>
<div id="post">
<pre>
<code>
</code>
</pre>
</div>

<h3>API URL</h3>
<div id="url">

</div>

<h3>Data returned</h3>
<div id="result">
<pre>
<code>

</code>
</pre>
</div>
</body>
</html>