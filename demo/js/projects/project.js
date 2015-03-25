$(function() {
    var html = $('#project'),
        project, tasks;
    $.ajax({
        type: "POST",
        url: '/api/projects/',
        data: {"projects_code":get.project},
        success: function(data) {
            project = data[0];
            html.append('<h2>' + project.projects_name + '</h2>');
            html.append('<ul><li>Code: ' + project.projects_code + '</li><li>Client: ' + project.projects_client.users_name + '</li><li>Project Manager: ' + project.projects_manager.users_name + '</li><li>Project Lead: ' + project.projects_lead.users_name + '</li></ul>');
            html.append('<div><h5>Description</h5><p>' + project.projects_desc + '</p></div>');
            var table = $('<table></table>');
            
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
                    tasks.forEach(function(task) {
                        table.append('<tr><td>' + task.tasks_count + '</td><td><a href="/tasks/task?task=' + project.projects_code + '-' + task.tasks_count + '">' + task.tasks_title + '</a></td><td>' + task.tasks_status + '</td><td>' + task.tasks_priority + '</td></tr>');
                    });
                    $('#tasks').append(table);
                    $('#tasks .loader').remove();
                },
                error: function(data) {
                    var error = $.parseJSON(data.responseText);
                    $('#tasks').append(error.message);
                    $('#tasks .loader').remove();
                }
            });
        },
        error: function(data) {
            var error = $.parseJSON(data.responseText);
            $('#project').append('<p>' + error.message + '</p>');
            $('#tasks').remove();
        }
    }).always(function() {
        $('.loader', html).remove();
    });
    
});