$(function() {
    window.sidebar = $('#sidebar');
    
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
    
    // close search box when click outside of searchbox
    $(document).click(function() {
        closeSearch();
    });
    
    $('nav li[data-sidebar]').mouseenter(function() {
        openSidebar();
    });
    
    $('.nav').mouseleave(function() {
        closeSidebar();
    });
    
    $('nav li:not([data-sidebar])').mouseenter(function() {
        closeSidebar();
    });
    
    
});

var openSearch = function() {
    $('.search-box').stop();
    $('.search-box').switchClass("closed", "open", 800);

    // assign click event to trigger search
    $('.search-btn').on('click search', function() {
        var searchTerm = $('.search-input').val();
        window.location.href = '/search/?term=' + searchTerm;
    });
};

var closeSearch = function() {
    $('.search-box').stop();
    $('.search-box').switchClass("open", "closed", 500);
    $('.search-btn').off('click search'); // remove click event to prevent search on closed form
};

var openSidebar = function() {
    sidebar.switchClass( "closed", "open", 500);
    sidebar.attr('style', '');
}

var closeSidebar = function() {
    if (sidebar.hasClass('closed')) {
        sidebar.attr('style', '');
    }
    sidebar.stop().switchClass( "open", "closed", 500);
}

var toggleSidebar = function() {
    if (sidebar.width() > 0) {
        sidebar.switchClass("open", "closed", 500);
    } else {
        sidebar.switchClass("closed", "open", 500);
    }
}