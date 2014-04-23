$(function() {
    var tasks;

    $.ajax({
        type: "POST",
        url: "/api/generic/",
        data: {"table_name": "tasks_status", "order": "tasks_status_id"},
        success: function(data) {
            data.forEach(function(status) {
                $('#workflow table thead tr').append('<th data-status-id="' + status.tasks_status_id + '">' + status.tasks_status + '</th>');
                 $('#workflow table tbody tr').append('<td data-status-id="' + status.tasks_status_id + '"></td>');
            });

            $.ajax({
                type: "POST",
                url: "/api/tasks/",
                data: {"order": "tasks_count"}, // get session.users_id as default
                success: function(data) {
                    tasks = data;
                    tasks.forEach(function(task) {
                        $('#workflow table tbody tr').find('td[data-status-id="' + task.tasks_status_id + '"]').append('<div>' + task.tasks_title + '</div>');
                    });
                }
            });

        }
    });

});