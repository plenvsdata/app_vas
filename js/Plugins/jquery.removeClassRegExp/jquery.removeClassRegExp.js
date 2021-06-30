$.fn.removeClassRegExp = function (regexp) {
    if(regexp && (typeof regexp==='string' || typeof regexp==='object')) {
        regexp = typeof regexp === 'string' ? regexp = new RegExp(regexp) : regexp;
        $(this).each(function () {
            $(this).removeClass(function(i,c) {
                var classes = [];
                $.each(c.split(' '), function(i,c) {
                    if(regexp.test(c)) { classes.push(c); }
                });
                return classes.join(' ');
            });
        });
    }
    return this;
};