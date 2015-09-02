$(function() {
    var tasks, projects, users;

    var taskResults = $('#task-results');
    var projectResults = $('#project-results');
    var userResults = $('#user-results');

    var performSearch = function(searchTerm) {
        taskResults.html(window.loadingGif);
        projectResults.html(window.loadingGif);
        userResults.html(window.loadingGif);

        $.ajax({
            type: "POST",
            url: "/api/search/",
            data: {"search_type":"tasks", "search_term":searchTerm},
            success: function(data) {
                tasks = data;
                tasks.forEach(function(task) {
                    taskResults.append('<div><a href="/tasks/task/?task=' + task.projects_code + '-' + task.tasks_count + '">' + task.tasks_title + '</a></div>');
                });
            },
            error: function(res) {
                var message = JSON.parse(res.responseText).message;
                taskResults.append('<p>' + message + '</p>');
            }
        }).always(function() {
            $('.loader', taskResults).remove();
        });

        $.ajax({
            type: "POST",
            url: "/api/search/",
            data: {"search_type":"projects", "search_term":searchTerm},
            success: function(data) {
                projects = data;
                projects.forEach(function(project) {
                    projectResults.append('<div><a href="/projects/project/?project=' + project.projects_code + '">' + project.projects_name + '</div>');
                });
            },
            error: function(res) {
                var message = JSON.parse(res.responseText).message;
                projectResults.append('<p>' + message + '</p>');
            }
        }).always(function() {
            $('.loader', projectResults).remove();
        });

        $.ajax({
            type: "POST",
            url: "/api/search/",
            data: {"search_type":"users", "search_term":searchTerm},
            success: function(data) {
                users = data;
                users.forEach(function(user) {
                    userResults.append('<div><a href="/userss/user/?name=' + user.users_name + '">' + user.users_name + '</div>');
                });
            },
            error: function(res) {
                var message = JSON.parse(res.responseText).message;
                userResults.append('<p>' + message + '</p>');
            }
        }).always(function() {
            $('.loader', userResults).remove();
        });

    };

    if (get.term.length > 0) {
        performSearch(get.term);
    }

    $('form').submit(function(e) {
        e.preventDefault();
        performSearch($('[name="term"]').val());
    });

});