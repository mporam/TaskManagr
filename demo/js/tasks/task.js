get.projects_code = get.task.split("-")[0];
get.tasks_count = get.task.split("-")[1];

$(function() {
    var content = $('#task'),
        task, comments;

    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"tasks_count" : get.tasks_count, "projects_code" : get.projects_code},
        success: function(data) {
            task = data[0]; // uses [0] as we only want one task
            if (session.users_type < 4) {
                content.append('<a href="/tasks/new/?task=' + task.tasks_code + '" class="btn right">Edit Task</a>');
            }
            content.append('<h2>' + task.tasks_title + '</h2>');
            content.append('<ul><li>Status: ' + task.tasks_status + '</li>');
            content.append('<li>Priority: ' + task.tasks_priority + '</li>');
            content.append('<li>Deadline: ' + task.tasks_deadline + '</li>');
            content.append('<li>Type: ' + task.tasks_type + '</li>');
            content.append('<li>Assigned to: ' + task.tasks_assignee.users_name + '</li>');
            content.append('<li>Reported by: ' + task.tasks_reporter.users_name + '</li>');
            if (task.tasks_related) {
                content.append('<li>Relates to: <a href="/tasks/task/?task=' + task.projects_code + '-' + task.tasks_related.tasks_count + '">' + task.projects_code + '-' + task.tasks_related.tasks_count + ' ' + task.tasks_related.tasks_title + '</a></li></ul>');
            }
            content.append('<div><h5>Description</h5><p>' + task.tasks_desc + '</p></div>');

            getComments(task);
        },
        error: function(data) {
            data = $.parseJSON(data.responseText);
            content.html('<h2>' + data.code + ' - ' + data.message + '</h2>');
        }
    }).always(function() {
        $('#task .loader').remove();
    });;
    
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
                getComments(task);
            },
            error: function(data) {
                
            }
        });
        
    });

});

var getComments = function(task) {
    
    $.ajax({
        type: "POST",
        url: "/api/comments/",
        data: {"comments_task_id" : task.tasks_id, "comments_access" : session.users_type_id},
        success: function(data) {
            comments = data;
            comments.forEach(function(comment) {
                $('#comments').append('<div class="comment"><h4>' + comment.comment_user.users_name + ' <span>' + comment.comments_added + '</span></h4><p>' + comment.comments_comment + '</p></div>');
            });
        },
        error: function(data) {
            data = $.parseJSON(data.responseText);
            $('#comments').append('<p>' + data.message + '</p>');
        }
    }).always(function() {
        $('#comments .loader').remove();
    });
};