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
                
                data.users_id = 5;

                $.ajax({
                    type: "POST",
                    url: '/api/users/delete/',
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

                $.ajax({
                    type: "POST",
                    url: '/api/comments/delete/',
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

                $.ajax({
                    type: "POST",
                    url: '/api/projects/delete/',
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
                
                data.tasks_id = 5;

                $.ajax({
                    type: "POST",
                    url: '/api/tasks/delete/',
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
    <button type="button" id="project">Delete Project</button>
    <button type="button" id="task">Delete Task</button>
    <button type="button" id="comment">Delete Comment</button>
    <button type="button" id="user">Delete User</button>
    <h3>Data returned</h3>
    <div id="result">
        <pre>
            <code>
            </code>
        </pre>
    </div>
    
</body>
</html>
