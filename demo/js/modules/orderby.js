var orderBy = {};

$(function() {
   $('.orderBy li').click(function() {
       $this = $(this);
       console.log($this.text());
   });

});

var createOrderBy = function(options) {
    if (typeof options != "object") {
        $('.orderBy ul').append('<li class="err-msg">Error getting Filters</li>');
        return false;
    }

    $.each(options, function(label, options) {
        var li = '<li>' + label;
        li += '<ul>';

        $.each(options, function (index, val) {
            if (typeof val == "string") {
                li +='<li><input type="radio" name="orderBy" value="' + val + '">' + val.replace('_', ' ') + '</li>';
            } else if (typeof val == "number") {
                li +='<li><input type="radio" name="orderBy" value="' + val + '">' + val + '</li>';
            }
        });

        li += '</ul></li>';
        $('.orderBy > ul').append(li);
    });
};