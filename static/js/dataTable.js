//custom dataTable sorting functions
jQuery.fn.dataTableExt.oSort['date-formatted-asc'] = function (a, b) {
    var ukDatea = a.split('/');
    var ukDateb = b.split('/');

    var x = (ukDatea[2] + ukDatea[0] + ukDatea[1]) * 1;
    var y = (ukDateb[2] + ukDateb[0] + ukDateb[1]) * 1;
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
};

jQuery.fn.dataTableExt.oSort['date-formatted-desc'] = function (a, b) {
    var ukDatea = a.split('/');
    var ukDateb = b.split('/');

    var x = (ukDatea[2] + ukDatea[0] + ukDatea[1]) * 1;
    var y = (ukDateb[2] + ukDateb[0] + ukDateb[1]) * 1;
    return ((x < y) ? 1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['plprice-formatted-asc'] = function (a, b) {
    var ukDatea = a.split('/');
    var ukDateb = b.split('/');

    var x = (ukDatea[2] + ukDatea[0] + ukDatea[1]) * 1;
    var y = (ukDateb[2] + ukDateb[0] + ukDateb[1]) * 1;
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
};

jQuery.fn.dataTableExt.oSort['plprice-formatted-desc'] = function (a, b) {
    var ukDatea = a.split('/');
    var ukDateb = b.split('/');

    var x = (ukDatea[2] + ukDatea[0] + ukDatea[1]) * 1;
    var y = (ukDateb[2] + ukDateb[0] + ukDateb[1]) * 1;
    return ((x < y) ? 1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['currency-asc'] = function (a, b) {
    /* Remove any commas (assumes that if present all strings will have a fixed number of d.p) */
    var x = a == "-" ? 0 : a.replace(/,/g, "");
    var y = b == "-" ? 0 : b.replace(/,/g, "");

    /* Remove the currency sign */
    x = x.substring(1);
    y = y.substring(1);

    /* Parse and return */
    x = parseFloat(x);
    y = parseFloat(y);
    return x - y;
};

jQuery.fn.dataTableExt.oSort['currency-desc'] = function (a, b) {
    /* Remove any commas (assumes that if present all strings will have a fixed number of d.p) */
    var x = a == "-" ? 0 : a.replace(/,/g, "");
    var y = b == "-" ? 0 : b.replace(/,/g, "");

    /* Remove the currency sign */
    x = x.substring(1);
    y = y.substring(1);

    /* Parse and return */
    x = parseFloat(x);
    y = parseFloat(y);
    return y - x;
};

$(document).ready(function () {
    $('.dataTables').dataTable({
        "bJQueryUI": true,
        "bAutoWidth": false,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lir>'
    });
    });
    $('.dataTables-upload-clients').dataTable({
        "bJQueryUI": true,
        "bAutoWidth": false,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [
            [-1],
            ["All"]
        ],
        "iDisplayLength": -1,
        "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lir>'
    });

    $('.dataTables-history').dataTable({
        "aaSorting": [[0, "desc"]],
        "aoColumns": [
            {iDataSort: 1},
            {bVisible: false},
            null,
            null,
            null,
            null,
            null
        ],
        "bJQueryUI": true,
        "bAutoWidth": false,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lir>'
    });

    $('.dataTables-proposals').dataTable({
        "aoColumns": [
            {bSortable: false},
            {"sType": "date-formatted"},
            null,
            null,
            null,
            null,
            {"sType": "currency"},
            null,
            null
        ],
        "aaSorting": [
            [1, "desc"]
        ],
        "bJQueryUI": true,
        "bAutoWidth": false,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lir>'
    });

    $('.dataTables-clients').dataTable({
        "aoColumns": [
            {bSortable: false},
            null,
            null,
            null,
            null,
            null,
            {"bSearchable": false}
        ], "bJQueryUI": true,
        "bAutoWidth": false,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lir>'
    });