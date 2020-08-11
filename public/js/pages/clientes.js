$(function () {
    $("#tableBase").DataTable({
        "autoWidth": false
    });
    $('#example1').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });

    $('.select2').select2({
        width: '100%'
    });
    $('.select-notsearch').select2({
        dropdownParent: $(".card-body"),
        width: '100%',
        minimumResultsForSearch: Infinity
    });
});
