$(function() {
    window.sidebar = $('#sidebar');
    window.sidebarInner = $('#sidebar .sidebar-inner');
    
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
        openSidebar();
        sidebar.trigger('sidebar-' + $(this).data('sidebar'));
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
        if (sidebarInner.html().length > 0) return false;
        sidebarInner.append('<h3>Projects</h3>');
        $.ajax({
            type: "POST",
            url: '/api/projects/',
            data: {},
            success: function(data) {
                data.forEach(function(item) {
                    sidebarInner.append('<div>' + item.projects_name + '</div>');
                });
            },
            error: function() {
                sidebarInner.append('<p>Error getting data</p>');
            }
        });
    });
    
    // event handler for projects sidebar
    sidebar.on('sidebar-tasks', function() {
        if (sidebarInner.html().length > 0) return false;
        sidebarInner.append('<h3>Tasks</h3>');
        $.ajax({
            type: "POST",
            url: '/api/tasks/',
            data: {},
            success: function(data) {
                data.forEach(function(item) {
                    sidebarInner.append('<div>' + item.tasks_title + '</div>');
                });
            },
            error: function() {
                sidebarInner.append('<p>Error getting data</p>');
            }
        });
    });
    
});

var openSearch = function() {
	console.log('open');
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
	console.log('close');
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
    sidebar.switchClass( "closed", "open", 500);
    sidebar.attr('style', '');
    sidebarInner.html('');
    sidebar.trigger('opened');
};

var closeSidebar = function() {
    if (sidebar.hasClass('closed')) {
        sidebar.attr('style', '');
    }
    sidebar.stop().switchClass( "open", "closed", 500);
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
