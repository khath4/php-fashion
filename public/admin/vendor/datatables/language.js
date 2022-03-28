 $(document).ready(function() {
    $('#dataTable').DataTable( {
        "language":{
        "decimal":        "",
        "emptyTable":     "No data available in table",
        "info":           "Hiển Thị _START_ đến _END_ Trong _TOTAL_ mục",
        "infoEmpty":      "Hiển Thị 0 to 0 of 0 mục",
        "infoFiltered":   "(filtered from _MAX_ total mục)",
        "infoPostFix":    "",
        "thousands":      ",",
        "lengthMenu":     "Hiển Thị _MENU_ mục",
        "loadingRecords": "Loading...",
        "processing":     "Processing...",
        "search":         "Tìm Kiếm:",
        "zeroRecords":    "Không có dữ liệu.",
        "paginate": {
            "first":      "First",
            "last":       "Last",
            "next":       "Next",
            "previous":   "Previous"
        },
        "aria": {
            "sortAscending":  ": activate to sort column ascending",
            "sortDescending": ": activate to sort column descending"
        }
    }
    } ).order( [ 0, 'DESC' ] )
    .draw();
} );
    