import $ from 'jquery';

$(document).ready(function() {
    $('#searchInput').focus();
});

$('#searchInput').on('keyup', function() {
    let filter = $(this).val().toUpperCase();

    $('#satellite-table tr:gt(0)').each(function () {
        let td = $(this).find('td:eq(0)');
        if (td) {
            let txtValue = td.text().toUpperCase();
            $(this).toggle(txtValue.indexOf(filter) > -1);
        }
    });
});