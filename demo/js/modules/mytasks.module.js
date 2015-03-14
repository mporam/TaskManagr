$(function() {
    // get all current users tasks
    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"tasks_assignee": session.users_id},
        success: function(data) {
            data.forEach(function(task) {
                $('#mytasks table tbody').append('<tr><td><a href="/tasks/task?task=' + task.tasks_code + '">' + task.tasks_code + '</a></td><td><span class="priority-icon ' + task.tasks_priority + '"></span></td><td><a href="/tasks/task?task=' + task.tasks_code + '">' + task.tasks_title + '</a></td><td>' + task.tasks_deadline + '</td></tr>');
            });
        },
        error: function(XHR) {
            var result = $.parseJSON(XHR.responseText);
            $('#mytasks table').remove();
            $('#mytasks').append('<p>' + result.message + '</p>');
        }
    }).always(function() {
        $('#mytasks .loader').remove();
    });
});