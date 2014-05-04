var projects;

$(function() {

    $('#projects').load('/projects/includes/list.php', function() {
        $.ajax({
            type: "POST",
            url: '/api/projects/',
            data: {},
            success: function(data) {
                projects = data;
                $('body').trigger('complete');
                projects.forEach(function(project) {
                    $.ajax({
                        type: "POST",
                        url: '/api/tasks/',
                        data: {count: "true", projects_id: project.projects_id},
                        success: function(taskCount) {
                            var row = '<tr>';
                            row += '<td><a href="/projects/project/?project=' + project.projects_code + '">' + project.projects_code + '</a></td>';
                            row += '<td><a href="/projects/project/?project=' + project.projects_code + '">' + project.projects_name + ' (' + taskCount + ')</a></td>';
                            row += '<td><a href="/users/user/?name=' + project.projects_lead.users_name + '">' + project.projects_lead.users_name + '</a></td>';
                            row += '<td><a href="/users/user/?name=' + project.projects_manager.users_name + '">' + project.projects_manager.users_name + '</a></td>';
                            row += '<td><a href="/users/user/?name=' + project.projects_client.users_name + '">' + project.projects_client.users_name + '</a></td>';
                            row += '</tr>';
                            $('#projects table tbody').append(row );
                        }
                    });
                });
            }
        });
    });

    
    $('body').on('complete', function() {
        $('#projects .load, #projects table tbody > *').remove();
    });
        
});