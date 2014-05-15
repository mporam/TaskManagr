$(function() {
var user;

    $.ajax({
        type: "POST",
        url: "/api/users/",
        data: {"users_name" : get.name},
        success: function(data) {
            user = data[0]; // uses [0] as we only want one user
            $('#user').html('');
            $('#user').append('<h3>' + user.users_name + '</h3>');
            $('#user').append('<p>Email:' + user.users_email + '</p>');
            $('#user').append('<p>Type:' + user.users_type_name + '</p>');
            $('#user').append('<img src="' + user.users_image + '">');
        },
        error: function(data) {
            data = $.parseJSON(data.responseText);
            $('#user').html('<h2>' + data.code + ' - ' + data.message + '</h2>');
        }
    });
    
    
});