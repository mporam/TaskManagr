$(function() {
    // Get users "in progress" tasks
    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"tasks_assignee": session.users_id, "tasks_status": "2", "order": "tasks_priority_id DESC"},
        success: function(data) {
            data.forEach(function(task) {
                $('#inprogress tbody').append('<tr><td><a href="/tasks/task?task=' + task.tasks_code + '">' + task.tasks_code + ' ' + task.tasks_title + '</a></td><td><span class="priority-icon ' + task.tasks_priority + '"></span></td></tr>');
            });
        },
        error: function(XHR) {
            var result = $.parseJSON(XHR.responseText);
            $('#inprogress table').remove();
            $('#inprogress').append('<p>' + result.message + '</p>');
        }
    }).always(function() {
        $('#inprogress .loader').remove();
    });
});