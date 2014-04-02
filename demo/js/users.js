var users;

$(function() {
    if (typeof data.users_name !== "undefined") {
        // code for a project view
        $('#users').load('/projects/includes/list.php', function() {
            $.ajax({
                type: "POST",
                url: '/api/users/',
                data: data,
                success: function(data) {
                    users = data;
                    $('body').trigger('complete');
                    users.forEach(function(user) {
                        var row = '<tr>';
                        row += '<td><a href="/users/?name=' + user.users_name + '">' + user.users_name + '</a></td>';
                        row += '<td>' + user.users_email + '</td>';
                        row += '<td>' + user.users_type + '</td>';
                        row += '<td>' + user.users_image + '</td>';
                        row += '</tr>';
                        $('#users table tbody').append(row);
                    });
                }
            });
        });
    } else {
        $('#users').load('/users/includes/list.php', function() {
            $.ajax({
                type: "POST",
                url: '/api/users/',
                data: data,
                success: function(data) {
                    users = data;
                    $('body').trigger('complete');
                    users.forEach(function(user) {
                        var row = '<tr>';
                        row += '<td><a href="/users/?name=' + user.users_name + '">' + user.users_name + '</a></td>';
                        row += '<td>' + user.users_email + '</td>';
                        row += '<td>' + user.users_type + '</td>';
                        row += '<td>' + user.users_image + '</td>';
                        row += '</tr>';
                        $('#users table tbody').append(row);
                    });
                }
            });
        });
    }
    
    $('body').on('complete', function() {
        $('#users .load, #users table tbody > *').remove();
    });
        
});