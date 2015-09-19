<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/top.php'); ?>
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/js/ckeditor/adapters/jquery.js"></script>
    <script src="/js/tasks/new.js"></script>
    <title>Admin</title>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/header.php'); ?>
    <div id="new-task">
        <h3>Create New Task</h3>
        <form>
            <div class="form-group">
                <label for="tasks_projects">Project*</label>
                <select name="tasks_projects" id="tasks_projects" required>
                    <option></option>
                </select>
            </div>
            <div class="form-group">
                <label for="tasks_name">Task Name*</label>
                <input type="text" name="tasks_title" id="tasks_title" required />
            </div>
            <div class="form-group">
                <label for="tasks_type">Type*</label>
                <select name="tasks_type" id="tasks_type" required>
                    <option></option>
                </select>
            </div>
            <div class="form-group">
                <label for="tasks_assignee">Assignee*</label>
                <select name=tasks_assignee" id="tasks_assignee" required>
                    <option value="<?php echo $_SESSION['users_id']; ?>">Current User - <?php echo $_SESSION['users_name']; ?></option>
                </select>
            </div>
            <div class="form-group">
                <label for="tasks_reporter">Reporter*</label>
                <select name=tasks_reporter" id="tasks_reporter" required>
                    <option value="<?php echo $_SESSION['users_id']; ?>">Current User - <?php echo $_SESSION['users_name']; ?></option>
                </select>
            </div>
            <div class="form-group textarea">
                <label for="tasks_desc">Description</label>
                <textarea name="tasks_desc" id="tasks_desc"></textarea>
            </div>
            <div class="form-group">
                <label for="tasks_priority">Priority*</label>
                <select name=tasks_priority" id="tasks_priority" required>
                </select>
            </div>
            <div class="form-group">
                <label for="tasks_deadline">Deadline</label>
                <input type="date" name="tasks_deadline" id="tasks_deadline" placeholder="YYYY-MM-DD" />
                <?php // I suggest using a datepicker plugin for this ?>
            </div>
            <div class="form-group">
                <label for="tasks_related">Related to</label>
                <input type="text" name="tasks_related" id="tasks_related" />
                <input type="hidden" name="tasks_related_hidden" id="tasks_related_hidden" />
                <ul id="related" class="dyn-list">
                </ul>
            </div>
            <p>* - required fields</p>
            <div class="form-group">
                <input type="submit" value="Create" />
            </div>
        </form>
    </div>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/bottom.php'); ?> 