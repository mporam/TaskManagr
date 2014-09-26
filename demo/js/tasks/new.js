$(function() {

$('textarea').ckeditor();

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
        if (val.length === 0) {
            $('#related').html('');
            return false;
        }
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
                if (tasks.length === 0) $('#related').html('<li>No tasks match your search term</li>');
            },
            error: function(data) {
                var result = $.parseJSON(data.responseText);
                if (result.code == 404) {
                    $('#related').html('<li>No tasks match your search term</li>');
                } else {
                    $('#related').html('<li>' + result.message + '</li>');
                }
            }
        });
    });

    $('form').submit(function(e) {
        e.preventDefault();
        var data = {
            tasks_project: $('#tasks_projects').val(),
            tasks_title: $('#tasks_name').val(),
            tasks_type: $('#tasks_type').val(),
            tasks_assignee: $('#tasks_assignee').val(),
            tasks_reporter: $('#tasks_reporter').val(),
            tasks_desc: $('#tasks_desc').val(),
            tasks_priority: $('#tasks_priority').val(),
            tasks_deadline: $('#tasks_deadline').val(),
            tasks_related: $('#tasks_related').val(),
            tasks_status: 1
        };
        $('.alert').remove();

        $.ajax({
            type: "POST",
            url: '/api/tasks/save/',
            data: data,
            success: function(result, textStatus, jqXHR) {
                window.location = '/tasks/task/?task=' + result.project + '-' + result.id;
            },
            error: function(data) {
                $('form').before('<div class="alert fail">' + data.message + ': ' + data.code + '</div>');
            }
        });
    });

});