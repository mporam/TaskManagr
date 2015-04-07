$(function() {
    var tasks;

    // get all task statuses
    $.ajax({
        type: "POST",
        url: "/api/generic/",
        data: {"table_name": "tasks_status", "order": "tasks_status_id"},
        success: function(data) {
            var size = 100/data.length;
            data.forEach(function(status) {
                $('#workflow-titles').append('<div class="col-0 column" style="width: ' + size + '%" data-status-id="' + status.tasks_status_id + '"><div><strong>' + status.tasks_status + '</strong></div></div>');
                $('#workflow-tasks').append('<div class="col-0 column ' + status.tasks_status.replace(/\s/g, "-") + '" style="width: ' + size + '%"  data-status-id="' + status.tasks_status_id + '"></div>');
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
                        $('#workflow-tasks')
                            .find('.column[data-status-id="' + task.tasks_status_id + '"]')
                            .append('<div class="task-box ' + task.tasks_priority + '" data-task-id="' + task.tasks_id + '">' +
                            '<a href="/tasks/task?task=' + task.projects_code + '-' + task.tasks_count + '">' + task.projects_code + '-' + task.tasks_count + ': ' + task.tasks_title + '</a>' +
                            '</div>');
                    });

                    $("#workflow-tasks .column").sortable({
                        connectWith: ".column",
                        placeholder: "task-placeholder"
                    });

                    $("#workflow-tasks .column").on("sortreceive", function(event, ui) {
                        var item = ui.item;
                        var col = $(this);
                        var sender = ui.sender;
                        
                        item.addClass('saving');

                        $.ajax({
                            type: "POST",
                            url: "/api/tasks/save/",
                            data: {"tasks_id":item.data('task-id'), "tasks_status":col.data('status-id')},
                            success: function(data) {
                                item.removeClass('saving').addClass('saved');
                                setTimeout(function(){item.removeClass('saved')}, 3000);
                            },
                            error: function() {
                                item.removeClass('saving').addClass('failed');
                                item.appendTo(sender);
                                setTimeout(function(){item.removeClass('failed')}, 3000);
                            }
                        });
                    });
                }
            });
    });

});