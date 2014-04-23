$(function() {
var task, comments;

    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"tasks_count" : get.tasks_count, "projects_code" : get.projects_code},
        success: function(data) {
            task = data[0]; // uses [0] as we only want one task
            $('#task').trigger('task-load');
        }        
    });

    $('#task').on('task-load', function() {
        $('#task').html('');
        $('#task').append('<h2>' + task.tasks_title + '</h2>');
        $('#task').append('<ul><li>Status: ' + task.tasks_status + '</li><li>Priority: ' + task.tasks_priority + '</li><li>Deadline: ' + task.tasks_deadline + '</li><li>Type: ' + task.tasks_type + '</li><li>Assigned to: ' + task.tasks_assignee.users_name + '</li><li>Reported by: ' + task.tasks_reporter.users_name + '</li></ul>');
         $('#task').append('<div><h5>Description</h5><p>' + task.tasks_desc + '</p></div>');

        $.ajax({
            type: "POST",
            url: "/api/comments/",
            data: {"comments_task_id" : task.tasks_id},
            success: function(data) {
                comments = data;
                $('#comments').prepend('<h3>Comments</h3>');
                if (comments.length == 0) {
                    $('#comments h3').after('<p>No one has left a comment yet</p>');
                } else {
                    comments.forEach(function(comment) {
                        $('#comments h3').after('<div class="comment"><h4>' + comment.comment_user.users_name + '</h4><p>' + comment.comments_comment + '</p></div>');
                    });
                }
            }        
    });

    });

});