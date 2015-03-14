$(function() {
    // load projects you are lead of
    $.post('/api/projects/', {"projects_lead": session.users_id}, function(data) {
        data.forEach(function(project) {
            loadGraph(project);
        });
    });


    var loadGraph = function(project) {
        // load stats data
        $.ajax({
            type: "POST",
            url: "/api/tasks/",
            data: {"count": "true", "projects_id": project.projects_id, "tasks_status" : "1,2,3,4,5,6"}, // using project 1, need to decide how to specify this
            success: function(data) {
                var temp = {};
                temp.total = data;
                temp.info = project.projects_name;
                $.ajax({
                    type: "POST",
                    url: "/api/tasks/",
                    data: {"count": "true", "projects_id": project.projects_id, "tasks_status" : "5,6"},
                    success: function(data) {
                        temp.part = data;
                        createGraph($('#stats .inner-module'), temp);
                    }
                }).always(function() {
                    $('#stats .loader').remove();
                });
            }
        });
    }
});