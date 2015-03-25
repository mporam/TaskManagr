var users;

$(function() {
    $.ajax({
        type: "POST",
        url: '/api/users/',
        data: '',
        success: function(data) {
            users = data;
            users.forEach(function(user) {
                var row = '<tr>';
                row += '<td><a href="/users/user/?name=' + user.users_name + '">' + user.users_name + '</a></td>';
                row += '<td>' + user.users_email + '</td>';
                row += '<td>' + user.users_type_name + '</td>';
                row += '<td><img src="' + user.users_image + '"></td>';
                row += '</tr>';
                $('#users table tbody').append(row);
            });
        }
    }).always(function() {
        $('body').trigger('complete');
    });
    
    $('body').on('complete', function() {
        $('#users .loader').remove();
    });
        
});