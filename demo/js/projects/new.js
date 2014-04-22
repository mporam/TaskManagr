$(function() {
var users;

    $.ajax({
        type: "POST",
        url: '/api/users/',
        data: '',
        success: function(data, textStatus, jqXHR) {
            users = data;
            users.forEach(function(user) {
                   if (user.users_type == "3" || user.users_type == "1") {
                       $('#projects_lead').append('<option value="' + user.users_id + '">' + user.users_name + '</option>');
                   }
                   if (user.users_type == "4") {
                       $('#projects_client').append('<option value="' + user.users_id + '">' + user.users_name + '</option>');
                   }
                   if (user.users_type == "2" || user.users_type == "1") {
                       $('#projects_manager').append('<option value="' + user.users_id + '">' + user.users_name + '</option>');
                   };
            });
        }
    });

    $('#projects_name').keyup(function() {
        if ($('#projects_code').data('edited') != "true") {
            var val = $(this).val();
            var valArray = val.split(" ");
            if (valArray.length > 2 && valArray[2].length > 0) {
                val = '';
                val += valArray[0].substr(0,1) + valArray[1].substr(0,1) + valArray[2].substr(0,1);
                $('#projects_code').val(val);
            } else {
                $('#projects_code').val(val.substr(0, 3));
            }
        }
    });

    $('#projects_code').keyup(function() {
        if ($(this).val().length > 0) { 
            $(this).data('edited', 'true');
        } else {
            $(this).data('edited', 'false');
        }
    });

});