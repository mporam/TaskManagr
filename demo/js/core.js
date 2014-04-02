var hash,
data = {};
$(window).on('hashchange', function() {
    hash = window.location.hash.split('/');
    hash.shift();
});
if (window.location.hash == "") {
    window.location.hash = '/';
}
