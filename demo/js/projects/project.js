window.options.filterBy = {
    'tasks_status': new Array(),
    'tasks_assignee': new Array(),
    'tasks_priority': new Array()
};

$(function() {
    var tabs = $('#project .tabs'),
        tasksContent = $('#project .tab-content [data-id="tasks"]'),
        project, tasks;

    var loadTasks = function(data) {
        /* ---------- this is for pagination if we want it. DO NOT TOUCH!
         var limit = {};
         limit.end = "20";
         if (window.location.hash.substr(2).length > 0) {
         limit.end = window.location.hash.substr(2) * 20;
         }
         limit.start = limit.end - 5;
         */
        tasksContent.prepend(window.loadingGif.addClass('left'));

        request = $.ajax({
            type: "POST",
            url: '/api/tasks/',
            data: data,
            success: function(data) {
                $('.dataTable', tasksContent).remove();
                tasks = data;

                var table = '<table class="dataTable">';
                table += '<tr>';
                table += '<th></th>';
                table += '<th>Status</th>';
                table += '<th>Task</th>';
                table += '<th>Code</th>';
                table += '<th>Assignee</th>';
                table += '<th>Deadline</th>';
                table += '</tr>';
                tasks.forEach(function(task) {
                    table += '<tr>';
                    table += '<td class="priority ' + task.tasks_priority + '"></td>';
                    table += '<td>' + task.tasks_status + '</td>';
                    table += '<td><a href="/tasks/task?task=' + task.tasks_code + '">' + task.tasks_title + '</a></td>';
                    table += '<td>' + task.tasks_code + '</td>';
                    table += '<td><a href="/users/user?name=' + task.tasks_assignee.users_name + '">' + task.tasks_assignee.users_name + '</a></td>';
                    table += '<td>' + task.tasks_deadline + '</td>';
                    table += '</tr>';
                });
                table += '</table>';
                tasksContent.append(table);
            },
            error: function(data) {
                if (typeof data == 'String') {
                    var error = $.parseJSON(data.responseText);
                    html.append('<div data-id="tasks"><p>' + error.message + '</p></div>');
                }
            }
        }).always(function() {
            $('.loader', tasksContent).remove();
            $('body').trigger('complete');
        });
    };

    $.ajax({
        type: "POST",
        url: '/api/projects/',
        data: {"projects_code":get.project},
        success: function(data) {
            project = data[0];
            var title = '<h2>' + project.projects_name + '</h2>';
            $('#project').prepend(title);

            tabs.append('<a href="#overview">Overview</a>');
            tabs.append('<a href="#tasks">Tasks</a>');

            var page = '<p>Code: ' + project.projects_code + '</p>';
                    page += '<p>Created: ' + project.projects_created + '</p>';
                    page += '<p>Manager: <a href="/users/user?name=' + project.projects_manager.users_name + '">' + project.projects_manager.users_name + '</a></p>';
                    page += '<p>Lead: <a href="/users/user?name=' + project.projects_lead.users_name + '">' + project.projects_lead.users_name + '</a></p>';
                    page += '<p>Client: <a href="/users/user?name=' + project.projects_client.users_name + '">' + project.projects_client.users_name + '</a></p>';
                    var outstanding = parseInt(project.tasks_total) - parseInt(project.tasks_completed);
                    page += '<p>Outstanding Tasks: ' + outstanding + ' of ' + project.tasks_total + '</p>';
                    page += '<p><h5>Description</h5>' + project.projects_desc + '</p>';
                page += '</div>';

            $('#project .tab-content [data-id="overview"]').html(page);

            createTabs();

            var load = {
                    "projects_id": project.projects_id,
                    "order": "tasks_status.tasks_status_id, tasks_priority.tasks_priority_id DESC, tasks.tasks_deadline"
            }; //, "limit": limit.start + ', ' + limit.end},
            loadTasks(load);
        },
        error: function(data) {
            var error = $.parseJSON(data.responseText);
            $('#project .tab-content [data-id="overview"]').append('<p>' + error.message + '</p>');
            tasksContent.remove();
        }
    });

    $('body').on('complete', function() {
        createFilterBy(tasks);
    });

    $('.filterBy').on('filter', function(e, filters) {
        $('.dataTable', tasksContent).fadeTo(100, 0.5);
        if (request) {
            request.abort();
        }
        var data = {};
        data.filterOut = filters;
        loadTasks(data);
    });
});