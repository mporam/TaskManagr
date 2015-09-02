var options = {
        orderBy:{
        },
        filterBy:{
            'projects_lead': new Array(),
            'projects_client': new Array(),
            'projects_manager': new Array(),
            'projects_created': new Array(),
            'projects_deleted': new Array(),
            'projects_completed': ['yes','no']
        }
    },
    projects,
    request;

$(function() {

    var display = function(data) {
        request = $.ajax({
            type: "POST",
            url: '/api/projects/',
            data: data,
            success: function(data) {
                $('#projects .grid').html(''); // remove any old errors
                projects = data;
                var i = 0;
                projects.forEach(function(project) {
                    var proj = '<div class="display-box col-3" data-proj-id="' + project.projects_id + '"><div class="display-box-inner">';
                    proj += '<h4><a href="/users/user/?name=' + project.projects_client.users_name + '"><img alt="' + project.projects_client.users_name + '" src="' + project.projects_client.users_image + '"></a>';
                    proj += '<a class="proj-title" href="/projects/project/?project=' + project.projects_code + '">' + project.projects_name + '</a></h4>';
                    proj += '<div class="cover-box"><img src="/images/site/icons/loading.gif" class="loader"></div>';
                    proj += '<div class="info-box">Code: <a class="right" href="/projects/project/?project=' + project.projects_code + '">' + project.projects_code + '</a>';
                    proj += '<p>Project Lead:<a href="/users/user/?name=' + project.projects_lead.users_name + '">' + project.projects_lead.users_name + '<img src="' + project.projects_lead.users_image + '"></a></p>';
                    proj += '<p>Project Manager:<a href="/users/user/?name=' + project.projects_manager.users_name + '">' + project.projects_manager.users_name + '<img src="' + project.projects_manager.users_image + '"></a></p>';
                    proj += '<p>' + project.tasks_completed + ' tasks completed of ' + project.tasks_total + ' total.</p>';
                    proj += '<p><a href="/projects/project/?project=' + project.projects_code + '">View Project ></a></p>';
                    proj += '</div>';
                    proj += '</div></div>';

                    $('#projects .grid').append(proj);

                    var graphData = project;
                    delete graphData.projects_name; // remove the name so we dont get a graph title
                    loadProjectGraph(graphData, $('[data-proj-id=' + project.projects_id + '] .cover-box'), {style:'invert', fontsize: 35});

                    $.each(project, function(key, value) {
                        if (typeof options.filterBy[key] !== "undefined" && options.filterBy[key].indexOf(value) == -1) {
                            options.filterBy[key].push(value);
                        }
                    });

                    i++;
                    if (i == projects.length) {
                        $('body').trigger('complete');
                    }
                });
            },
            error: function() {
                $('#projects .grid').html('<p class="col-12 err-msg">No Projects found, please try again.</p>');
            }
        }).always(function() {
            $('#projects .loader').remove();
        });
    };

    display({order: "projects_created ASC"});

    $('body').on('complete', function() {
        request = undefined;
        //createOrderBy(options.orderBy);
        createFilterBy(options.filterBy);
    });


    $('.filterBy').on('filter', function(e, filters) {
        $('#projects .grid').html('');
        if (request) {
            request.abort();
        }
        var data = {};
        data.filterOut = filters;
        data.order = "projects_created ASC";
        display(data);
    })

});