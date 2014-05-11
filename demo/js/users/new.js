$(function() {    
    
    // Get user types options for quick task update
    $.ajax({
        type: "POST",
        url: "/api/generic/",
        data: {"table_name": "users_type"},
        success: function(data) {
            data.forEach(function(type) {
                $('#users_type').append('<option value="' + type.users_type_id + '">' + type.users_type_name + '</option>');
            });
        }
    });
    
});