get.projects_code = get.task.split("-")[0];
get.tasks_count = get.task.split("-")[1];

$(function() {
    var task, comments;

    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"tasks_count" : get.tasks_count, "projects_code" : get.projects_code},
        success: function(data) {
            task = data[0]; // uses [0] as we only want one task
            $('#task').trigger('task-load');
        },
        error: function(data) {
            data = $.parseJSON(data.responseText);
            $('#task').html('<h2>' + data.code + ' - ' + data.message + '</h2>');
        }
    });

    $('#task').on('task-load', function() {
        $('#task').html('');
        $('#task').append('<h2>' + task.tasks_title + '</h2>');
        $('#task').append('<ul><li>Status: ' + task.tasks_status + '</li><li>Priority: ' + task.tasks_priority + '</li><li>Deadline: ' + task.tasks_deadline + '</li><li>Type: ' + task.tasks_type + '</li><li>Assigned to: ' + task.tasks_assignee.users_name + '</li><li>Reported by: ' + task.tasks_reporter.users_name + '</li></ul>');
        $('#task').append('<div><h5>Description</h5><p>' + task.tasks_desc + '</p></div>');

        getComments();
    });
    
    $('#comment-form').submit(function(e) {
        e.preventDefault();
        var comments_comment  = $('textarea', $(this)).val(),
            comments_user     = session.users_id,
            comments_access   = ($('select', $(this)).length ? $('select', $(this)).val() : 4);
        
        $.ajax({
            type: "POST",
            url: "/api/comments/save/",
            data: {"comments_task_id" : task.tasks_id, "comments_access" : comments_access, "comments_user": comments_user, "comments_comment": comments_comment},
            success: function(data) {
                getComments();
            },
            error: function(data) {
                
            }
        });
        
    });

});

var getComments = function() {
    
    $('#comments').html('');
    
    $.ajax({
        type: "POST",
        url: "/api/comments/",
        data: {"comments_task_id" : task.tasks_id, "comments_access" : session.users_type_id},
        success: function(data) {
            comments = data;
            $('#comments').prepend('<h3>Comments</h3>');
            comments.forEach(function(comment) {
                $('#comments h3').after('<div class="comment"><h4>' + comment.comment_user.users_name + ' <span>' + comment.comments_added + '</span></h4><p>' + comment.comments_comment + '</p></div>');
            });
        },
        error: function(data) {
            data = $.parseJSON(data.responseText);
            $('#comments').prepend('<h3>Comments</h3>');
            $('#comments h3').after('<p>' + data.message + '</p>');
        }
    });
}