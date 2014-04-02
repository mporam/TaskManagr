var projects;

$(function() {  
    $.ajax({
        type: "POST",
        url: '/api/projects/',
        data: data,
        success: function(data) {
            projects = data;
            $('body').trigger('complete');
        }
    });

    $('body').on('complete', function() {
        $('#projects .load, #projects table tbody > *').remove();
        projects.forEach(function(project) {
            var row = '<tr>';
            row += '<td><a href="/projects/?code=' + project.projects_code + '">' + project.projects_code + '</a></td>';
            row += '<td><a href="/projects/?code=' + project.projects_code + '">' + project.projects_name + '</a></td>';
            row += '<td><a href="/users/?name=' + project.projects_lead.users_name + '">' + project.projects_lead.users_name + '</a></td>';
            row += '<td><a href="/users/?name=' + project.projects_manager.users_name + '">' + project.projects_manager.users_name + '</a></td>';
            row += '<td><a href="/users/?name=' + project.projects_client.users_name + '">' + project.projects_client.users_name + '</a></td>';
            row += '</tr>';
            $('#projects table tbody').append(row);
        });
    });
    
    $(window).on('hashchange', function() {
        //data.projects_code = hash[0];
        $.ajax({
            type: "POST",
            url: '/api/projects/',
            data: data,
            success: function(data) {
                projects = data;
                $('body').trigger('complete');
            }
        });
    });
    
});