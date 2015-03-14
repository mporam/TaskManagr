$(function() {

    
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
    }).always(function() {
        $('#taskupdate .loader').remove();
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