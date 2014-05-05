var hash, sidebar;
if (window.location.hash == "") {
    window.location.hash = '/';
}
$(function() {
    sidebar = $('#sidebar');
});

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
