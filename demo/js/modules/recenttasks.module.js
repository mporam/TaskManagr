$(function() {
    // get recent tasks
    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"limit":"3", "order":"tasks_updated"},
        success: function(data) {
            data.forEach(function(task) {
                $('#recenttasks table tbody').append('<tr><td><a href="/tasks/task?task=' + task.tasks_code + '">' + task.tasks_code + ' ' + task.tasks_title + '</a></td><td><span class="priority-icon ' + task.tasks_priority + '"></span></td></tr>');
            });
        },
        error: function(XHR) {
            var result = $.parseJSON(XHR.responseText);
            $('#recenttasks table').remove();
            $('#recenttasks').append('<p>' + result.message + '</p>');
        }
    }).always(function() {
        $('#recenttasks .loader').remove();
    });
});