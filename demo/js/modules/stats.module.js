$(function() {
    // load projects you are lead of
    $.post('/api/projects/', {"projects_lead": session.users_id}, function(data) {
        data.forEach(function(project) {
            loadProjectGraph(project, $('#stats .inner-module'));
        });
    });
});