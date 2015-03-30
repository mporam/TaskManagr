$(function() {

    $('.module h3').click(function(e) {
        $(this).parents('.module').toggleClass('open closed');
        $(this).next().slideToggle();
        $(this).parents('.module').trigger('toggle');
    });

    window.sidebar = $('#sidebar');
    window.sidebarInner = $('#sidebar .sidebar-inner');
    window.sidebarContent = {};
    
    // define click event to open seach box
    $('.search-box').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if ($(this).hasClass('closed')) {
            openSearch();
        }
    });
    
    // trigger search on enter key press
    $('.search-input').keydown(function(e){    
        if(e.which===13){
           $('.search-btn').trigger('search');
        }
    });
    
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
        $.ajax({
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
        $.ajax({
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
    
});

var openSearch = function() {
    $('.search-box').stop();
    $('.search-box').removeClass('closed');
    $('.search-box').animate({
        width: '205px'
    }, 800,
    'swing',
    function() {
        $('.search-box').addClass('open');
        $('.search-box').attr('style', '');
    });

    $(document).on('click', closeSearch);

    // assign click event to trigger search
    $('.search-btn').on('click search', function() {
        var searchTerm = $('.search-input').val();
        window.location.href = '/search/?term=' + searchTerm;
    });
};

var closeSearch = function() {
    $('.search-box').stop();
    $('.search-box').animate({
        width: '28px'
    }, 800,
    'swing',
    function() {
		$('.search-box').removeClass('open');
		$('.search-box').addClass('closed');
        $('.search-box').attr('style', '');
		$(document).off('click', closeSearch);
        $('.search-btn').off('click search'); // remove click event to prevent search on closed form
    });
};

var openSidebar = function() {
    sidebar.stop();
    sidebar.switchClass("closed", "open", 500);
    sidebar.attr('style', '');
    sidebar.trigger('opened');
};

var closeSidebar = function() {
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
 * Create a circliful graph
 * @param parent object a jquery object of the parent to add the graph too
 * @param options object
 */

var createGraph = function(parent, options) {
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

    data = $.extend({}, defaults, options);
    if (data.part > 0) {
        data.percent = Math.round((data.part/data.total)*100);
    }
    if (isNaN(data.percent)) {
        data.percent = 0;
    }
    data.text = data.percent + '%';

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

    $.each(data, function(key, value) {
        graph.attr('data-' + key, value);
    });

    parent.append(graph);
    graph.circliful();
    graph.addClass(graphclass);
};

// clears sidebar cache every 30 seconds to keep data up to date
window.sidebarRefresh = setTimeout(function() {
    window.sidebarContent = {};
    window.sidebarRefresh = 1;
}, 30000);
