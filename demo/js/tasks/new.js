var tasks, projects, users, relatedRequest;
$(function() {

    $.when(

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
        }),

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
        }),

        $.ajax({
            type: "POST",
            url: '/api/generic/',
            data: {"table_name": "tasks_type"},
            success: function(data, textStatus, jqXHR) {
                data.forEach(function(type) {
                    $('#tasks_type').append('<option value="' + type.tasks_type_id + '">' + type.tasks_type + '</option>');
                });
            }
        }),

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
        })
    ).then(function() {
        if (typeof get.task != 'undefined' && get.task.length > 0) {
            get.projects_code = get.task.split("-")[0];
            get.tasks_count = get.task.split("-")[1];

            $('h3').text('Edit Task: ' + get.task);

            $.ajax({
                type: "POST",
                url: '/api/tasks/',
                data: {"tasks_count": get.tasks_count, "projects_code": get.projects_code},
                success: function (data) {
                    $.each(data[0], function (field, value) {
                        if ($('#' + field).length > 0 && value) {
                            $('#' + field).val(value);
                        }
                    });
                }
            });
        };

        $('textarea').ckeditor();
    });

    // trigger related search on keyup
    $('#tasks_related').keyup(function() {
        var val = $(this).val();
        getRelatedTasks(val);
    });

    // perform related tasks search again when project changes
    $('#tasks_projects').change(function() {
        $('#tasks_related_hidden').val('');
        var val = $('#tasks_related').val();
        getRelatedTasks(val);
    });

    $('form').submit(function(e) {
        e.preventDefault();
        // needs validation
        var data = {
            tasks_project: $('#tasks_projects').val(),
            tasks_title: $('#tasks_title').val(),
            tasks_type: $('#tasks_type').val(),
            tasks_assignee: $('#tasks_assignee').val(),
            tasks_reporter: $('#tasks_reporter').val(),
            tasks_desc: $('#tasks_desc').val(),
            tasks_priority: $('#tasks_priority').val(),
            tasks_deadline: $('#tasks_deadline').val(),
            tasks_related: $('#tasks_related_hidden').val(),
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
                $('form').before('<div class="alert fail">' + data.message + ': ' + data.code + '</div>'); // @TODO: dont think this works!
            }
        });
    });

});

var getRelatedTasks = function(val) {
    $('#tasks_related + .inline-msg').remove();
    $('#tasks_related').removeClass('success');
    if (relatedRequest) {
        relatedRequest.abort();
    }
    $('#related').html('<img src="/images/site/icons/loading.gif" class="loader">');
    if (val.length === 0) {
        $('#related').html('');
        return false;
    }
    relatedRequest = $.ajax({
        type: "POST",
        url: '/api/search/',
        data: {
            "search_type": "tasks",
            "search_term": val,
            "limit": 5,
            "search_field2": "tasks_desc",
            "search_term2": val,
            "search_project": $('#tasks_projects').val()
        },
        success: function(data, textStatus, jqXHR) {
            tasks = data;
            $('#related').html('');
            tasks.forEach(function(task) {
                $('#related').append('<li data-id="' + task.tasks_id + '">' + task.projects_code + '-' + task.tasks_count + ' ' + task.tasks_title + '</li>');
            });
            if (tasks.length === 0) {
                $('#related').html('<li class="err-msg">No tasks match your search term</li>');
            } else {
                relatedClickHandler();
            }
        },
        error: function(data) {
            if (data.responseText) {
                var result = $.parseJSON(data.responseText);
                if (result.code == 404) {
                    $('#related').html('<li class="err-msg">No tasks match your search term</li>');
                } else {
                    $('#related').html('<li class="err-msg">' + result.message + '</li>');
                }
            }
        }
    });
};

var relatedClickHandler = function() {
    $('#related li').off();

    $('#related li').click(function() {
        $('#tasks_related').val($(this).text());
        $('#tasks_related_hidden').val($(this).data('id'));
        $('#tasks_related + .inline-msg').remove();
        $('#tasks_related').addClass('success').after('<span class="inline-msg success-msg">Selected</span>');
    });
};