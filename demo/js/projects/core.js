var projects;

$(function() {

    $.ajax({
        type: "POST",
        url: '/api/projects/',
        data: {order: "projects_created ASC"},
        success: function(data) {
            projects = data;
            var i = 0;
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
                        row += '<td><a href="/users/user/?name=' + project.projects_client.users_name + '">' + project.projects_client.users_name + '<img src="' + project.projects_client.users_image + '"></a></td>';
                        row += '</tr>';
                        $('#projects table tbody').append(row);
                        i++;
                        if (i == projects.length) {
                            $('body').trigger('complete');
                        }
                    }
                });
            });
        }
    });

    $('body').on('complete', function() {
        $('#projects .loader').remove();
    });
        
});