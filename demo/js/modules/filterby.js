var filterby = {};

$(function() {
   $('.filterBy').on('change', 'input', function() {
       var $this = $(this);
       var section = $this.attr('name');
       var filter = $this.val();
       var status = $this.prop("checked");
       if (!status) {
           if (typeof filterby[section] == 'undefined') {
               filterby[section] = new Array();
           }
           filterby[section].push(filter);
       } else {
           var i = filterby[section].indexOf(filter);
           filterby[section].splice(i,1);
       }
       $('.filterBy').trigger('filter', [filterby]);
   });

});

var createFilterBy = function(data) {
    $.each(data, function(key, object) { // loop array of objs
        $.each(object, function(key, value) { // loop obj properties
            if (typeof window.options.filterBy[key] !== "undefined" && window.options.filterBy[key].indexOf(value) == -1) {
                window.options.filterBy[key].push(value);
            }
        });
    });

    $('.filterBy > ul').html('');
    if (window.options.filterBy.length < 1) {
        $('.filterBy ul').html('<li class="err-msg">Error getting Filters</li>');
        return false;
    }

    $.each(window.options.filterBy, function(label, values) {
        if (values.length > 1) { // ignore any filters with only one option
            var dups = new Array(); // array for detecting duplicate users
            var li = '<li>' +  label.replace('_', ' ');
            li += '<ul>';
            $.each(values, function (index, val) {
                if (typeof val == "string") {
                    li += '<li><label><input type="checkbox" checked name="' + label + '" value="' + val + '">' + val.replace('_', ' ') + '</label></li>';
                } else if (typeof val == "number") {
                    li += '<li><label><input type="checkbox" checked name="' + label + '" value="' + val + '">' + val + '</label></li>';
                } else if (typeof val == "object" && val.hasOwnProperty('users_name')) {
                    if ($.inArray(val.users_name, dups) === -1) {
                        li += '<li><label><input type="checkbox" checked name="' + label + '" value="' + val.users_id + '">' + val.users_name + '</label></li>';
                        dups.push(val.users_name);
                    }
                }
            });

            li += '</ul></li>';
            if (dups.length !== 1) { // this is not great but only way of ignoring single user filters
                $('.filterBy > ul').append(li);
            }
        }
    });

    createFilterBy = function() {}; // this prevents the filterby from being called multiple times on a page

};