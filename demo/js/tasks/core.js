$(function() {
    var projects;

    $.ajax({
        type: "POST",
        url: "/api/projects/",
        data: "",
        success: function(data) {
            $('#tasks').html('');
            projects = data;
            projects.forEach(function(project) {
                var list, table, title;

                title = $('<h3>' + project.projects_name + '</h3>');
                list = $('<div class="project"></div>');
                table = $('<table></table>');

                $.ajax({
                    type: "POST",
                    url: "/api/tasks/",
                    data: {"projects_id": project.projects_id, "limit": "5"},
                    success: function(data) {
                        data.forEach(function(task) {
                            table.append('<tr><td>' + task.tasks_count + '</td><td><a href="/tasks/task?task=' + project.projects_code + '-' + task.tasks_count + '">' + task.tasks_title + '</a></td><td>' + task.tasks_status + '</td><td>' + task.tasks_priority + '</td></tr>');
                        });
                        list.append(title).append(table);
                    }
                });

                $('#tasks').append(list);

            });

        }
    });

});