$(function() {
var project, tasks
    $.ajax({
        type: "POST",
        url: '/api/projects/',
        data: {"projects_code":get.project},
        success: function(data) {
            project = data[0];
            $('#project').append('<h2>' + project.projects_name + '</h2>');
            $('#project').append('<ul><li>Code: ' + project.projects_code + '</li><li>Client: ' + project.projects_client.users_name + '</li><li>Project Manager: ' + project.projects_manager.users_name + '</li><li>Project Lead: ' + project.projects_lead.users_name + '</li></ul>');
            $('#project').append('<div><h5>Description</h5><p>' + project.projects_desc + '</p></div>');
            
            var table = $('<table></table>');
            
            var limit = {};
            limit.end = "5";
            if (window.location.hash.substr(2).length > 0) {
                limit.end = window.location.hash.substr(2) * 5;
            }
            limit.start = limit.end - 5;
            
            $.ajax({
                type: "POST",
                url: '/api/tasks/',
                data: {"projects_id":project.projects_id, "limit": limit.start + ', ' + limit.end},
                success: function(data) {
                    tasks = data;
                    tasks.forEach(function(task) {
                        table.append('<tr><td>' + task.tasks_count + '</td><td><a href="/tasks/task?task=' + project.projects_code + '-' + task.tasks_count + '">' + task.tasks_title + '</a></td><td>' + task.tasks_status + '</td><td>' + task.tasks_priority + '</td></tr>');
                    });
                    $('#tasks').append('<h3>Tasks</h3>').append(table);
                }
            });
        }
    });
    
});