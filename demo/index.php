<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
    <script src="/js/libraries/jquery.circliful.min.js" type="text/javascript"></script>
    <script src="/js/dashboard/core.js" type="text/javascript"></script>
    <title>Admin</title>
   
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
    
    <h2>Dashboard</h2>

    <div id="stats" class="col-8">
        <h3>My stats</h3>
        <div class="inner-module">
            
        </div>
    </div>
    
    <div id="inprogress" class="col-3">
        <h3>In Progress</h3>
        <div class="inner-module">
            <table>
            </table>
        </div>
    </div>
    
    <div id="mytasks" class="col-8">
        <h3>My Tasks</h3> 
        <div class="inner-module"> 
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
    </div>
    
    <div id="recenttasks" class="col-3">
        <h3>Recent Tasks</h3>
        <div class="inner-module">   
            <table>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    <div id="taskupdate" class="col-6">
        <h3>Quick task update</h3>
        <div class="inner-module">
            <form>
                <div class="module-container">
                    <img class="gravatar" src="<?php echo (empty($_SESSION['users_image']) ? get_gravatar($_SESSION['users_email']) : $_SESSION['users_image']); ?>">
                    <div class="update">
                        <div class="form-group-inline">
                            <label>Update task:</label>
                            <input type="text" name="tasks_code">
                            <input type="hidden" name="tasks_id">
                            <ul class="dyn-list" id="taskupdatelist"></ul>
                        </div>

                        <div class="form-group-inline">
                            <label>Update status:</label>
                            <select name="tasks_status">
                                <option>Select a task</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="module-footer">
                    <textarea name="comment_comment" placeholder="Write your comment&hellip;"></textarea>
                    <input type="submit" value="Update Task">
                </div>
            </form>
        </div>
    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?>
