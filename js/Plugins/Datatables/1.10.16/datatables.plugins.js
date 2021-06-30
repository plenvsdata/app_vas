$.fn.dataTable.render.ellipsis = function ( cutoff ) {
    return function ( data, type, row ) {
        return type === 'display' && data.length > cutoff ?
            data.substr( 0, cutoff ) +'…' :
            data;
    }
};