$(function() {
    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"tasks_assignee": session.users_id, "tasks_status": "2"},
        success: function(data) {
            data.forEach(function(task) {
                $('#inprogress table').append('<tr><td>' + task.tasks_title + '</td></tr>');
            });
        }
    });
});