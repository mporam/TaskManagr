$(function() {

    window.loadingGif = '<img src="/images/site/icons/loading.gif" class="loader">';

    $('.dropdown .title').click(function(e) {
        e.preventDefault();
        var $this = $(this).next('ul');
        $this.toggleClass('open');
        $('.dropdown > ul').not($this).removeClass('open');
    });

    $('.module h3').click(function(e) {
        $(this).parents('.module').toggleClass('open closed');
        $(this).next().slideToggle();
        $(this).parents('.module').trigger('toggle');
    });

    window.sidebar = $('#sidebar');
    window.sidebarInner = $('#sidebar .sidebar-inner');
    window.sidebarContent = {};
    
    // open sidebar and trigger event
    $('nav li[data-sidebar]').mouseenter(function() {
        var eName = $(this).data('sidebar'); // get event name
        sidebarInner.html('');
        openSidebar(); // open the sidebar
        if (typeof sidebarContent[eName] !== 'undefined' && sidebarContent[eName].length > 0) { // check if data is cached
            sidebarInner.html(sidebarContent[eName]); // load cache into sidebar
        } else {
            sidebar.trigger('sidebar-' + $(this).data('sidebar')); // load data from server if not cached
        }
    });
    
    // close sidebar when mouse out from sidebar
    $('.nav').mouseleave(function() {
        closeSidebar();
    });
    
    // close sidebar when mouse enter link without sidebar
    $('nav li:not([data-sidebar])').mouseenter(function() {
        closeSidebar();
    });

    // event handler for projects sidebar
    sidebar.on('sidebar-projects', function() {
        sidebarInner.append('<h3>Projects</h3>');
        window.sidebarLookup = $.ajax({
            type: "POST",
            url: '/api/projects/',
            data: {},
            success: function(data) {
                data.forEach(function(item) {
                    sidebarInner.append('<div class="item"><a href="/projects/project/?project=' + item.projects_code + '">' + item.projects_name + '</a></div>');
                });
                sidebarContent.projects = sidebarInner.html();
            },
            error: function() {
                sidebarInner.append('<p>Error getting data</p>');
            }
        });
    });

    // event handler for projects sidebar
    sidebar.on('sidebar-users', function() {
        sidebarInner.append('<h3>Users</h3>');
        window.sidebarLookup = $.ajax({
            type: "POST",
            url: '/api/users/',
            data: {},
            success: function(data) {
                data.forEach(function(item) {
                    sidebarInner.append('<div class="item"><a href="/users/user/?name=' + item.users_name + '">' + item.users_name + '</a></div>');
                });
                sidebarContent.users = sidebarInner.html();
            },
            error: function() {
                sidebarInner.append('<p>Error getting data</p>');
            }
        });
    });

    // trigger search on enter key press
    $('.search-input').keydown(function(e){
        if(e.which===13){
            $('.search-btn').trigger('search');
        }
    });

    $('.search-results > span').click(function() {
        closeSearch();
    });

    $('.search-btn').on('click search', function() {
        var searchTerm = $('.search-input').val();
        if (searchTerm.length > 0) {
            var $results = $('.search-results');
            var $taskResults = $('[data-type="tasks"]', $results);
            var $projectResults = $('[data-type="projects"]', $results);
            var $userResults = $('[data-type="users"]', $results);
            $('> a', $results).attr('href', '/search/?term=' + searchTerm);
            $results.animate({
                height: $('main').outerHeight()
            }, 400, function() {
                $(this).addClass('open');
            });

            // search tasks
            $.ajax({
                type: "POST",
                url: '/api/search/',
                data: {search_type:"tasks", search_term: searchTerm, limit: 3},
                success: function(tasks) {
                    tasks.forEach(function(task) {
                        $taskResults.append('<div><a href="/tasks/task?task=' + task.tasks_code + '">' + task.tasks_code + ' ' + task.tasks_title + '</a></div>');
                    });
                },
                error: function() {
                    $taskResults.append('<p class="err-msg">No Results Found</p>');
                }
            }).always(function() {
                $('.loader', $taskResults).remove();
            });

            // search projects
            $.ajax({
                type: "POST",
                url: '/api/search/',
                data: {search_type:"projects", search_term: searchTerm, limit: 3},
                success: function(projects) {
                    projects.forEach(function(project) {
                        $projectResults.append('<div><a href="/projects/project/?project=' + project.projects_code + '">' + project.projects_name + '</a></div>');
                    });
                },
                error: function() {
                    $projectResults.append('<p class="err-msg">No Results Found</p>');
                }
            }).always(function() {
                $('.loader', $projectResults).remove();
            });

            // search users
            $.ajax({
                type: "POST",
                url: '/api/search/',
                data: {search_type:"users", search_term: searchTerm, limit: 3},
                success: function(users) {
                    users.forEach(function(user) {
                        $userResults.append('<div><a href="/users/user/?name=' + user.users_name + '">' + user.users_name + '</a></div>');
                    });
                },
                error: function() {
                    $userResults.append('<p class="err-msg">No Results Found</p>');
                }
            }).always(function() {
                $('.loader', $userResults).remove();
            });
        }

        $('.search-input').on('keydown', closeSearch);

    });

});

var createTabs = function() {
    openTab(location.hash.replace('#', ''));

    $('.tabs a').click(function() {
        var content = $(this).attr('href').replace('#', '');
        openTab(content);
    });


};

var openTab = function(tab) {
    if ($('[data-id="' + tab + '"]').length > 0 && $('[href="#' + tab + '"]').length > 0) {
        $('.tabs a').removeClass('active');
        $('[href="#' + tab + '"]').addClass('active')
        $('.tab-content > div').removeClass('open');
        $('[data-id="' + tab + '"]').addClass('open');
    }
};

var closeSearch = function() {

    $('.search-input').off('keydown', closeSearch);
    var $results = $('.search-results');
    var $taskResults = $('[data-type="tasks"]', $results);
    var $projectResults = $('[data-type="projects"]', $results);
    var $userResults = $('[data-type="users"]', $results);
    $results.animate({
        height: '0'
    }, 400, function() {
        $(this).removeClass('open');
        $('p, div', $taskResults).remove();
        $('p, div', $projectResults).remove();
        $('p, div', $userResults).remove();
    });
};

var openSidebar = function() {
    sidebar.stop();
    sidebar.switchClass("closed", "open", 500);
    sidebar.attr('style', '');
    sidebar.trigger('opened');
};

var closeSidebar = function() {
    if (window.sidebarLookup) {
        window.sidebarLookup.abort(); //cancel ajax request if running
    }
    if (sidebar.hasClass('closed')) {
        sidebar.attr('style', '');
    }
    sidebar.switchClass("open", "closed", 300);
    sidebarInner.html('');
    sidebar.trigger('closed');
};

var toggleSidebar = function() {
    if (sidebar.width() > 0) {
        closeSidebar();
    } else {
        openSidebar();
    }
};

/**
 * Create a completion graph for an individual project
 * @param project object a javascript object of the project to create a graph for
 * @param $el object a jquery object of the parent to add the graph too
 */
var loadProjectGraph = function(project, $el, options) {
    if (typeof options == 'undefined') {
        var options = {};
    }
    options.total = project.tasks_total;
    options.part = project.tasks_completed;
    if (project.hasOwnProperty('projects_name')) {
        options.info = project.projects_name;
    }
    $('.loader', $el).remove();
    createGraph($el, options);
}

/**
 * Create a circliful graph
 * @param $el object a jquery object of the parent to add the graph too
 * @param options object
 */

var createGraph = function($el, options) {
    if (!('part' in options) || !('total' in options)) {
        return false;
    }

    var defaults = {
        dimension: 120,
        width: 10,
        info: '',
        fontsize: '25',
        fgcolor:  '#61a9dc',
        bgcolor:  '#979797',
        percent: 0
    };
    var graphclass;

    var data = $.extend({}, defaults, options);

    if (typeof data.style != 'undefined' && data.style == 'invert') {
        delete data.style
        var container = $('<div></div>');
        container.addClass('circliful-invert');
    }

    if (data.part > 0 && data.percent === 0) {
        data.percent = Math.round((data.part/data.total)*100);
    }
    if (isNaN(data.percent)) {
        data.percent = 0;
    }
    data.text = data.percent + '<small>%</small>';

    if (data.percent < 34) {
        data.fgcolor = '#ff5454';
        graphclass = 'High';
    }
    if (data.percent < 67 && data.percent > 33) {
        data.fgcolor = '#f0c516';
        graphclass = 'Average';
    }
    if (data.percent > 66) {
        data.fgcolor = '#1cb56a';
        graphclass = 'Low';
    }

    delete data.part;
    delete data.total;
    var graph = $('<div></div>');
    graph.addClass(graphclass);

    if (typeof container != 'undefined') {
        data.fgcolor = '#ffffff';
        data.bgcolor = 'rgba(255, 255, 255, 0.5)';
        data.width   = '6';
        container.addClass(graphclass);
    }

    $.each(data, function(key, value) {
        graph.attr('data-' + key, value);
    });

    if (typeof container != 'undefined') {
        container.append(graph);
        $el.append(container);
    } else {
        $el.append(graph);
    }

    graph.circliful();
    $el.trigger('graph-load');
};

// clears sidebar cache every 30 seconds to keep data up to date
window.sidebarRefresh = setTimeout(function() {
    window.sidebarContent = {};
    window.sidebarRefresh = 1;
}, 30000);


var options = {
    orderBy:{
    },
    filterBy:{
    }
};