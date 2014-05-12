var hash, sidebar;
if (window.location.hash == "") {
    window.location.hash = '/';
}
$(function() {
    sidebar = $('#sidebar');
    
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
    
    
});

var openSearch = function() {
    $('.search-box').stop();
    $('.search-box').removeClass('closed');
    $('.search-box').animate({
        width: '250px'
    }, 800);

    // assign click event to trigger search
    $('.search-btn').on('click search', function() {
        var searchTerm = $('.search-input').val();
        console.log(searchTerm);
        //window.location.href = ;
    });

    $('.search-box').addClass('open');
};

var closeSearch = function() {
    $('.search-box').stop();
    $('.search-box').removeClass('open');
    $('.search-box').animate({
        width: '28px'
    }, 800);
    
    // remove click event to prevent search on closed form
    $('.search-btn').off('click search');
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