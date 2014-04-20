$(function() {
var tasks, projects, users;
    $.ajax({
        type: "POST",
        url: '/api/projects/',
        data: '',
        success: function(data, textStatus, jqXHR) {
            projects = data;
            projects.forEach(function(project) {
                $('#tasks_projects').append('<option value="' + project.projects_id + '">' + project.projects_name + '</option>');
            });
        }
    });

    $.ajax({
        type: "POST",
        url: '/api/users/',
        data: {"users_type": "1"},
        success: function(data, textStatus, jqXHR) {
            users = data;
            users.forEach(function(user) {
                $('#tasks_assignee').append('<option value="' + user.users_id + '">' + user.users_name + '</option>');
                $('#tasks_reporter').append('<option value="' + user.users_id + '">' + user.users_name + '</option>');
            });
        }
    });

    $.ajax({
        type: "POST",
        url: '/api/generic/',
        data: {"table_name": "tasks_type"},
        success: function(data, textStatus, jqXHR) {
            data.forEach(function(type) {
                $('#tasks_type').append('<option value="' + type.tasks_type_id + '">' + type.tasks_type + '</option>');
            });
        }
    });

    $.ajax({
        type: "POST",
        url: '/api/generic/',
        data: {"table_name": "tasks_priority", "order": "tasks_priority_id"},
        success: function(data, textStatus, jqXHR) {
            data.forEach(function(priority) {
                if (priority.tasks_priority_id == '2') {
                    $('#tasks_priority').append('<option value="' + priority.tasks_priority_id + '" selected>' + priority.tasks_priority+ '</option>');
                } else {
                    $('#tasks_priority').append('<option value="' + priority.tasks_priority_id + '">' + priority.tasks_priority+ '</option>');
                }
            });
        }
    });

    $('#tasks_related').keyup(function() {
        var val = $(this).val();
        $.ajax({
            type: "POST",
            url: '/api/search/',
            data: {"search_type": "tasks",  "search_term": val},
            success: function(data, textStatus, jqXHR) {
                tasks = data;
                $('#related').html('');
                tasks.forEach(function(task) {
                    $('#related').append('<li>' + task.tasks_title + '</li>');
                });
                if (tasks.length == 0) $('#related').html('<li>No tasks match your search term</li>')
            },
            error: function(data, textStatus, jqXHR) {
                $('#related').html('');
            }
        });
    });

});