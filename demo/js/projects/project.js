window.options.filterBy = {
    'tasks_status': new Array(),
    'tasks_assignee': new Array(),
    'tasks_priority': new Array()
};

$(function() {
    var tabs = $('#project .tabs'),
        project, tasks;

    $.ajax({
        type: "POST",
        url: '/api/projects/',
        data: {"projects_code":get.project},
        success: function(data) {
            project = data[0];
            var title = '<h2>' + project.projects_name + '</h2>';
            $('#project').prepend(title);

            tabs.append('<a href="#overview">Overview</a>');

            var page = '<p>Code:' + project.projects_code + '</p>';
                    page += '<p>Created:' + project.projects_created + '</p>';
                    page += '<p>Manager:' + project.projects_manager.users_name + '</p>';
                    page += '<p>Lead:' + project.projects_lead.users_name + '</p>';
                    page += '<p>Client:' + project.projects_client.users_name + '</p>';
                    var outstanding = parseInt(project.tasks_total) - parseInt(project.tasks_completed);
                    page += '<p>Outstanding Tasks: ' + outstanding + ' of ' + project.tasks_total + '</p>';
                    page += '<p><h5>Description</h5>' + project.projects_desc + '</p>';
                page += '</div>';

            $('#project .tab-content [data-id="overview"]').html(page);

            /* ---------- this is for pagination if we want it. DO NOT TOUCH!
             var limit = {};
             limit.end = "20";
             if (window.location.hash.substr(2).length > 0) {
             limit.end = window.location.hash.substr(2) * 20;
             }
             limit.start = limit.end - 5;
             */

            tabs.append(window.loadingGif);
            $.ajax({
                type: "POST",
                url: '/api/tasks/',
                data: {
                    "projects_id": project.projects_id,
                    "order": "tasks_status.tasks_status_id, tasks_priority.tasks_priority_id DESC, tasks.tasks_deadline"
                }, //, "limit": limit.start + ', ' + limit.end},
                success: function(data) {
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
                    $('#project .tab-content [data-id="tasks"]').append(table);
                },
                error: function(data) {
                    var error = $.parseJSON(data.responseText);
                    html.append('<div data-id="tasks"><p>' + error.message + '</p></div>');
                }
            }).always(function() {
                $('.loader', tabs).remove();
                tabs.append('<a href="#tasks">Tasks</a>');

                $('body').trigger('complete');
            });


        },
        error: function(data) {
            var error = $.parseJSON(data.responseText);
            $('#project .tab-content [data-id="overview"]').append('<p>' + error.message + '</p>');
            $('#project .tab-content [data-id="tasks"]').remove();
        }
    });

    $('body').on('complete', function() {
        createTabs();
        createFilterBy(tasks);
    });
});