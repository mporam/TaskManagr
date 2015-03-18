<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/class/modules/module.abstract.php');

class taskupdate extends moduleAbstract {

    public function display() {
        $el = '';
        $el .= '<h3>Quick Task Update</h3>';
        $el .= '<form>
                <div class="inner-module">
                    <img class="gravatar" src="' . (empty($_SESSION['users_image']) ? get_gravatar($_SESSION['users_email']) : $_SESSION['users_image']) . '">
                    <div class="update">
                        <div class="form-group-inline">
                            <label>Update task:</label>
                            <input type="text" name="tasks_code" placeholder="Task Code">
                            <input type="hidden" name="tasks_id">
                            <ul class="dyn-list" id="taskupdatelist"></ul>
                        </div>

                        <div class="form-group-inline">
                            <label>Update status:</label>
                            <select name="tasks_status">
                                <option>--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="module-footer">
                    <textarea name="comment_comment" placeholder="Write your comment&hellip;"></textarea>
                    <input type="submit" value="Update Task">
                </div>
            </form>';

        return $el;
    }
} 