<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
    <script src="/js/libraries/jquery.circliful.min.js" type="text/javascript"></script>
    <script src="/js/dashboard/core.js" type="text/javascript"></script>
    <title>Admin</title>
</head>
<body>    
   
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
    
    <h2>Dashboard</h2>

    <div id="stats">
        <h3>My stats</h3>
    </div>
    
    <div id="inprogress">
        <h3>In Progress</h3>
        <table>
        </table>
    </div>
    
    <div id="mytasks">
        <h3>My Tasks</h3>   
        <table>
            <thead>
                <tr>
                    <th>Task no:</th>
                    <th>Priority:</th>
                    <th>Title:</th>
                    <th>Deadline:</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    
    <div id="recenttasks">
        <h3>Recent Tasks</h3>   
        <table>
            <tbody>
            </tbody>
        </table>
    </div>
    
    <div id="taskupdate" class="col-4">
        <h3>Quick task update</h3>
        <form>
            <div>
                <label>update task:</label>
                <input type="text" name="tasks_code">
                <input type="hidden" name="tasks_id">
            </div>
            <ul class="task-list">
            </ul>
            <div>
                <label>update status:</label>
                <select name="tasks_status">
                    <option>Select a task</option>
                </select>
            </div>
            <div>
                <textarea name="comment_comment" placeholder="Write your comment&hellip;"></textarea>
            </div>
            <div>
                <input type="submit" value="submit">
            </div>
        </form>
    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?> 