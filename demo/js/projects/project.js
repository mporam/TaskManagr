$(function() {
    var html = $('#project'),
        project, tasks;
    $.ajax({
        type: "POST",
        url: '/api/projects/',
        data: {"projects_code":get.project},
        success: function(data) {
            project = data[0];
            var page = '<h2>' + project.projects_name + '</h2>';
            page += '<div class="tabs">';
                page += '<a href="#overview" class="active">Overview</a>';
                page += '<a href="#tasks">Tasks</a>';
            page += '</div>';

            page += '<div class="tab-content">';
                page += '<div data-id="overview" class="open">';
                    page += '<p>Code:' + project.projects_code + '</p>';
                    page += '<p>Created:' + project.projects_created + '</p>';
                    page += '<p>Manager:' + project.projects_manager.users_name + '</p>';
                    page += '<p>Lead:' + project.projects_lead.users_name + '</p>';
                    page += '<p>Client:' + project.projects_client.users_name + '</p>';
                    var outstanding = parseInt(project.tasks_total) - parseInt(project.tasks_completed);
                    page += '<p>Outstanding Tasks: ' + outstanding + ' of ' + project.tasks_total + '</p>';
                    page += '<p><h5>Description</h5>' + project.projects_desc + '</p>';
                page += '</div>';

                page += '<div data-id="tasks"><img src="/images/site/icons/loading.gif" class="loader"></div>';
            page += '</div>';

            html.append(page);
            var tasksTab = $('[data-id="tasks"]');
            
            /* ---------- this is for pagination if we want it. DO NOT TOUCH!
            var limit = {};
            limit.end = "20";
            if (window.location.hash.substr(2).length > 0) {
                limit.end = window.location.hash.substr(2) * 20;
            }
            limit.start = limit.end - 5;
            */
            
            $.ajax({
                type: "POST",
                url: '/api/tasks/',
                data: {"projects_id":project.projects_id}, //, "limit": limit.start + ', ' + limit.end},
                success: function(data) {
                    tasks = data;
                    var table = '<table>';
                    table += '<tr>';
                    table += '<th>Task Code</th>';
                    table += '<th>Name</th>';
                    table += '<th>Priority</th>';
                    table += '<th>Assignee</th>';
                    table += '<th>Status</th>';
                    table += '<th>Deadline</th>';
                    table += '</tr>';
                    tasks.forEach(function(task) {
                        table += '<tr>';
                        table += '<td>' + task.projects_code + '-' + task.tasks_count + '</td>';
                        table += '<td><a href="/tasks/task?task=' + task.projects_code + '-' + task.tasks_count + '">' + task.tasks_title + '</a></td>';
                        table += '<td>' + task.tasks_priority + '</td>';
                        table += '<td><a href="/users/user?name=' + task.tasks_assignee.users_name + '">' + task.tasks_assignee.users_name + '</a></td>';
                        table += '<td>' + task.tasks_status + '</td>';
                        table += '<td>' + task.tasks_deadline + '</td>';
                        table += '</tr>';
                    });
                    table += '</table>';
                    tasksTab.html(table);
                },
                error: function(data) {
                    var error = $.parseJSON(data.responseText);
                    $('#tasks').append(error.message);
                    $('#tasks .loader').remove();
                }
            });

            $('body').trigger('complete');
        },
        error: function(data) {
            var error = $.parseJSON(data.responseText);
            $('#project').append('<p>' + error.message + '</p>');
            $('#tasks').remove();
        }
    }).always(function() {
        $('> .loader', html).remove();
    });

    $('body').on('complete', function() {
        createTabs();
    });

});