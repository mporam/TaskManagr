<?php
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/verify.php');
?>

<html>
<head>
   <script src="/js/libraries/jquery-1.10.1.min.js"></script>

    <script>
        $(function() {
            var data = {};

            $('#user').on('click', function(e) {
                e.preventDefault();
                
                data.users_name = 'Test Client 2';
                data.users_email = 'mikeoram@mikeoram.co.uk';
                data.users_type = 4;

                $.ajax({
                    type: "POST",
                    url: '/api/users/save/',
                    data: data,
                    success: function(data, textStatus, jqXHR) {
                        $('#result code').html(JSON.stringify(data, null, ' '));
                    },
                    error: function(data) {
                        $('#result code').html(JSON.stringify(data, null, ' '));
                    }
                });
            });

            $('#comment').on('click', function(e) {
                e.preventDefault();
                
                data.comments_id = 1
                data.comments_user = 1;
                data.comments_access = 2;
                data.comments_comment = 'This is the first comment saved by the API! - edited!';
                data.comments_task_id = 1;

                $.ajax({
                    type: "POST",
                    url: '/api/comments/save/',
                    data: data,
                    success: function(data, textStatus, jqXHR) {
                        $('#result code').html(JSON.stringify(data, null, ' '));
                    },
                    error: function(data) {
                        $('#result code').html(JSON.stringify(data, null, ' '));
                    }
                });
            });

            $('#project').on('click', function(e) {
                e.preventDefault();
                
                data.projects_id = 3;
                data.projects_name = 'Project from API edited';
                data.projects_code = 'API';
                data.projects_desc = 'Description from api insert';
                data.projects_lead = 1;
                data.projects_client = 3;
                data.projects_manager = 2;

                $.ajax({
                    type: "POST",
                    url: '/api/projects/save/',
                    data: data,
                    success: function(data, textStatus, jqXHR) {
                        $('#result code').html(JSON.stringify(data, null, ' '));
                    },
                    error: function(data) {
                        $('#result code').html(JSON.stringify(data, null, ' '));
                    }
                });
            });

            $('#task').on('click', function(e) {
                e.preventDefault();
                
                data.tasks_project = 1;
                data.tasks_type = 1;
                data.tasks_title = "Insert task via API";
                data.tasks_desc = "description from api";
                data.tasks_priority = 1;
                data.tasks_status = 3;
                data.tasks_deadline = "2016-12-03";
                data.tasks_reporter = 1;
                data.tasks_assignee = 2;
                data.tasks_related = 4;

                $.ajax({
                    type: "POST",
                    url: '/api/tasks/save/',
                    data: data,
                    success: function(data, textStatus, jqXHR) {
                        $('#result code').html(JSON.stringify(data, null, ' '));
                    },
                    error: function(data) {
                        $('#result code').html(JSON.stringify(data, null, ' '));
                    }
                });
            });
        });
    </script>
</head>

<body>
    <button type="button" id="project">Add a Project</button>
    <button type="button" id="task">Add a Task</button>
    <button type="button" id="comment">Add a Comment</button>
    <button type="button" id="user">Add a User</button>
    <h3>Data returned</h3>
    <div id="result">
        <pre>
            <code>
            </code>
        </pre>
    </div>
    
</body>
</html>