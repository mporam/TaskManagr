$(function() {
    var tasks;

    $.ajax({
        type: "POST",
        url: "/api/generic/",
        data: {"table_name": "tasks_status", "order": "tasks_status_id"},
        success: function(data) {
            data.forEach(function(status) {
                $('#workflow table thead tr').append('<th data-status-id="' + status.tasks_status_id + '">' + status.tasks_status + '</th>');
                 $('#workflow table tbody tr').append('<td class="column" data-status-id="' + status.tasks_status_id + '"></td>');
            });
            $('#workflow').trigger('thead-load');
        }
    });

    $('#workflow').on('thead-load', function() {
        var request = {},
            user = session.users_id;
        if (typeof get.user !== "undefined") user = get.user;

        if (session.users_type == "4") { // client
            request = {"order": "tasks_count", "projects_client": session.users_id};
        } else if (session.users_type == "2" && user == session.users_id ) { // project manager
            request = {"order": "tasks_count", "tasks_reporter": user};
        } else { // developer and admin
            request = {"order": "tasks_count", "tasks_assignee": user};
        }
            $.ajax({
                type: "POST",
                url: "/api/tasks/",
                data: request,
                success: function(data) {
                    tasks = data;
                    tasks.forEach(function(task) {
                        $('#workflow table tbody tr').find('td[data-status-id="' + task.tasks_status_id + '"]').append('<div class="task-box" data-task-id="' + task.tasks_id + '">' + task.projects_code + '-' + task.tasks_count + ': ' + task.tasks_title + '</div>');
                    });

                    $("#workflow .column").sortable({
                        connectWith: ".column",
                        placeholder: "task-placeholder"
                    });

                    $("#workflow .column").on("sortreceive", function(event, ui) {
                        var item = ui.item;
                        var col = $(this);

                        $.ajax({
                            type: "POST",
                            url: "/api/tasks/save/",
                            data: {"tasks_id":item.data('task-id'), "tasks_status":col.data('status-id')},
                            success: function(data) {
                                
                            }
                        });
                    });
                }
            });
    });

});