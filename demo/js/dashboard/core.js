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
                });
            }
        });
    }
    
    // Get users "in progress" tasks
    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"tasks_assignee": session.users_id, "tasks_status": "2"},
        success: function(data) {
            data.forEach(function(task) {
                $('#inprogress table').append('<tr><td>' + task.tasks_title + '</td></tr>');
            });
        },
        error: function(XHR) {
            var result = $.parseJSON(XHR.responseText);
            $('#inprogress table').remove();
            $('#inprogress').append('<p>' + result.message + '</p>');
        }
    });
    
    // get all current users tasks
    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"tasks_assignee": session.users_id},
        success: function(data) {
            data.forEach(function(task) {
                $('#mytasks table tbody').append('<tr><td>' + task.tasks_code + '</td><td>' + task.tasks_priority + '</td><td>' + task.tasks_title + '</td><td>' + task.tasks_deadline + '</td></tr>');
            });
        },
        error: function(XHR) {
            var result = $.parseJSON(XHR.responseText);
            $('#mytasks table').remove();
            $('#mytasks').append('<p>' + result.message + '</p>');
        }
    });
    
    // get recent tasks
    $.ajax({
        type: "POST",
        url: "/api/tasks/",
        data: {"limit":"3", "order":"tasks_updated"},
        success: function(data) {
            data.forEach(function(task) {
                $('#recenttasks table tbody').append('<tr><td>' + task.tasks_code + ' ' + task.tasks_title + '</td></tr>');
            });
        },
        error: function(XHR) {
            var result = $.parseJSON(XHR.responseText);
            $('#recenttasks table').remove();
            $('##recenttasks').append('<p>' + result.message + '</p>');
        }
    });
    
    // Get task status options for quick task update
    $.ajax({
        type: "POST",
        url: "/api/generic/",
        data: {"table_name": "tasks_status"},
        success: function(data) {
            data.forEach(function(status) {
                $('#taskupdate select').append('<option value="' + status.tasks_status_id + '">' + status.tasks_status + '</option>');
            });
        },
        error : function(data) {
            var result = $.parseJSON(data.responseText);
            $('#taskupdate form').html('<p>Task update load failed. (' + result.code + ')</p>')
        }
    });
    
    // tasks lookup for quick tasks update
    $('#taskupdate [name="tasks_code"]').keyup(function() {
        var val = $(this).val();
        if (val.length === 0) {
            $('#taskupdate [name="tasks_id"]').val('');
            $('#taskupdatelist').html('');
            $('#taskupdate select option').prop('selected', false);
            $('#taskupdate select option').first().prop('selected', true);
            return false;
        }
        var tasks;
        $.ajax({
            type: "POST",
            url: '/api/search/',
            data: {"search_type": "tasks", "field": "tasks_count",  "search_term": val, "field2":"projects_code", "search_term2":val},
            success: function(data) {
                tasks = data;
                // create list of tasks to select, once selected fill out form info
                $('#taskupdatelist').html('');
                tasks.forEach(function(task) {
                    var item = $('<li>' + task.tasks_code + '</li>').click(function(e){
                        $('#taskupdate [name="tasks_code"]').val(task.tasks_code);
                        $('#taskupdate [name="tasks_id"]').val(task.tasks_id);
                        $('#taskupdatelist').html('');
                        $('#taskupdate select option').prop('selected', false);
                        $('#taskupdate select option[value="' + task.tasks_status_id + '"]').prop('selected', true);
                    });
                    $('#taskupdatelist').append(item);
                });
            },
            error: function(data) {
                var result = $.parseJSON(data.responseText);
                if (result.code === 404) {
                    $('#taskupdatelist').html('<li>No tasks match your search term</li>');
                } else {
                    $('#taskupdatelist').html('<li>' + result.message + '</li>');
                }
                $('#taskupdate [name="tasks_id"]').val('');
                $('#taskupdate select option').prop('selected', false);
                $('#taskupdate select option').first().prop('selected', true);
            }
        });
    });
    
    // submit the comment form and send comment to server
    $('#taskupdate form').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var comment = $('textarea', form).val();
        var taskID = $('[name="tasks_id"]', form).val();
        var taskStatus = $('[name="tasks_status"]', form).val();
        
        if (comment.length > 0) {
            $.ajax({
                type: "POST",
                url: '/api/comments/save/',
                data: {"comments_user": session.users_id, "comments_access": "3",  "comments_comment": comment, "comments_task_id":taskID},
                success: function(data) {
                    data = $.parseJSON(data);
                    form.append('<p>' + data.message + '</p>');
                },
                error: function(data) {
                    data = $.parseJSON(data.responseText);
                    form.append('<p>' + data.message + '</p>');
                }
            });
        }
        
        $.ajax({
            type: "POST",
            url: '/api/tasks/save/',
            data: {"tasks_id": taskID, "tasks_status": taskStatus},
            success: function(data) {
                data = $.parseJSON(data);
                form.append('<p>' + data.message + '</p>');
            },
            error: function(data) {
                data = $.parseJSON(data.responseText);
                form.append('<p>' + data.message + '</p>');
            }
        });
        
    });
});