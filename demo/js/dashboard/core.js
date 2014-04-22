$(function() {
    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"tasks_assignee": session.users_id},
        success: function(data) {
            console.log(data);
            data.forEach(function(task) {
                if (task.tasks_status == "2") {
                    $('#inprogress table').append('<tr><td>' + task.tasks_title + '</td></tr>');
                }
            });
        }
    });
});