var hash,
data = {};
$(window).on('hashchange', function() {
    hash = window.location.hash.split('/');
    hash.shift();
    console.log(hash);
});
if (window.location.hash == "") {
    window.location.hash = '/';
} else {
    $(window).trigger('hashchange');
}
