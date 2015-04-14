var projects;

$(function() {

    $.ajax({
        type: "POST",
        url: '/api/projects/',
        data: {order: "projects_created ASC"},
        success: function(data) {
            projects = data;
            var i = 0;
            $('#projects .loader').remove();
            projects.forEach(function(project) {
                var proj = '<div class="display-box col-3" data-proj-id="' + project.projects_id + '"><div class="display-box-inner">';
                proj += '<h4><a href="/users/user/?name=' + project.projects_client.users_name + '"><img alt="' + project.projects_client.users_name + '" src="' + project.projects_client.users_image + '"></a>';
                proj += '<a class="proj-title" href="/projects/project/?project=' + project.projects_code + '">' + project.projects_name + '</a></h4>';
                proj += '<div class="cover-box"><img src="/images/site/icons/loading.gif" class="loader"></div>';
                proj += '<div class="info-box">Code: <a class="right" href="/projects/project/?project=' + project.projects_code + '">' + project.projects_code + '</a>';
                proj += '<p>Project Lead:<a href="/users/user/?name=' + project.projects_lead.users_name + '">' + project.projects_lead.users_name + '<img src="' + project.projects_lead.users_image + '"></a></p>';
                proj += '<p>Project Manager:<a href="/users/user/?name=' + project.projects_manager.users_name + '">' + project.projects_manager.users_name + '<img src="' + project.projects_manager.users_image + '"></a></p>';
                proj += '<p>' + project.tasks_total + '</p>';
                proj += '</div>';
                proj += '</div></div>';

                $('#projects .grid').append(proj);

                var graphData = project;
                delete graphData.projects_name; // remove the name so we dont get a graph title
                loadProjectGraph(graphData, $('[data-proj-id=' + project.projects_id + '] .cover-box'), {style:'invert', fontsize: 35});

                i++;
                if (i == projects.length) {
                    $('body').trigger('complete');
                }
            });
        }
    });

    $('body').on('complete', function() {
        $('#projects .loader').remove();
    });
        
});