var hash, sidebar;
if (window.location.hash == "") {
    window.location.hash = '/';
}
$(function() {
    sidebar = $('#sidebar');
    
    $('.search-box').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if ($(this).hasClass('closed')) {
            openSearch();
        }
    });
    
    $(document).click(function() {
        closeSearch();
    });
    
    
});

var openSearch = function() {
    $('.search-box').removeClass('closed');
    $('.search-box').animate({
        width: '250px'
    }, 800);

    $('.search-btn').on('click', function() {
        var searchTerm = $('.search-input').val();
        //window.location.href = ;
    })

    $('.search-box').addClass('open');
};

var closeSearch = function() {
    $('.search-box').removeClass('open');
    $('.search-box').animate({
        width: '28px'
    }, 800);
    $('.search-btn').off('click');
    $('.search-box').addClass('closed');
};

var openSidebar = function() {
    sidebar.removeClass('closed');
    sidebar.animate(
        {width: "20%"},
        2000,
        function() {
            sidebar.addClass('open');
        }
    );
}

var closeSidebar = function() {
    sidebar.removeClass('open');
    sidebar.animate(
        {width: "0"},
        2000,
        function() {
            sidebar.addClass('closed');
        }
    );
}