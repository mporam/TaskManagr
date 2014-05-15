$(function() {
    var tasks, projects;
    
    if (get.term.length > 0) {
        var searchTerm = get.term;
        $.ajax({
            type: "POST",
            url: "/api/search/",
            data: {"search_type":"tasks", "search_term":searchTerm},
            success: function(data) {
                tasks = data;
                tasks.forEach(function(task) {
                   $('#task-results').append('<div><a href="/tasks/task/?task=' + task.projects_code + '-' + task.tasks_count + '">' + task.tasks_title + '</a></div>'); 
                });
            },
            error: function(res) {
                var message = JSON.parse(res.responseText).message;
                $('#task-results').append('<p>' + message + '</p>');
            }
        });
        
        $.ajax({
            type: "POST",
            url: "/api/search/",
            data: {"search_type":"projects", "search_term":searchTerm},
            success: function(data) {
                projects = data;
                projects.forEach(function(project) {
                   $('#project-results').append('<div><a href="/projects/project/?project=' + project.projects_code + '">' + project.projects_name + '</div>'); 
                });
            },
            error: function(res) {
                var message = JSON.parse(res.responseText).message;
                $('#project-results').append('<p>' + message + '</p>');
            }
        });
    }
});