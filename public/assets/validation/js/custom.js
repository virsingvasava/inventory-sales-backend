 var customurl = SITE_URL;
$(document).ready(function(){
    
    setTimeout(function(){ $('.alert').fadeOut(3000); }, 3000);
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click','.icon_loader',function(){
        var $this = $(this);
        var html = $this.html();

        var loadingText = '<i class="fa fa-spinner fa-spin" role="status" aria-hidden="true"></i>';
        $(this).html(loadingText);
        $(this).prop("disabled", true);

        setTimeout(function(){ 
            $('.icon_loader').html(html);
            $('.icon_loader').prop("disabled", false);
        }, 5000);
    });

    $('#kiosk_table').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [6, 7] },
            { "orderable": true, "targets": [0, 1, 2, 3, 4, 5] } ]
    });

    $('#product_table').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [6] },
            { "orderable": true, "targets": [0, 1, 2, 3, 4, 5] } ]
    });

    $('#user_table').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [ 6, 7] },
            { "orderable": true, "targets": [0, 1, 2, 3, 4, 5] } ]
    });
    
    $('#notification_table').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [3] },
            { "orderable": true, "targets": [0, 1, 2] } ]
    });

    $('#brand_table').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [0] },
            { "orderable": true, "targets": [1] } ]
    });


    $('#pending_request_table').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [0, 6] },
            { "orderable": true, "targets": [1, 2, 3, 4, 5] } ]
    });


    $('#salesman_history_table').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [0] },
            { "orderable": true, "targets": [1, 2, 3, 4, 5, 6] } ]
    });

   
    $('#request_qty_table').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [5] },
            { "orderable": true, "targets": [0, 1, 2, 3, 4] } ]
    });

    $('#stocks_update_qty_table').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [5] },
            { "orderable": true, "targets": [0, 1, 2, 3, 4] } ]
    });


    $('#kiosk_view_products_list').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [0] },
            { "orderable": true, "targets": [0, 1, 2, 3, 4, 5] } ]
    });
    $('#kiosk_view_sales_history').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [0] },
            { "orderable": true, "targets": [1, 2, 3, 4, 5] } ]
    });

    $('#usersSales').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [8] },
            { "orderable": true, "targets": [0, 1, 2, 3, 4, 5, 6, 7] } ]
    });

    $('#insentive_list_table').dataTable({
        "bDestroy": true, "lengthChange": true, "bFilter": true, "pageLength": 10,
        "bPaginate": true, "paging": true, "bInfo": true, "stateSave": true,
        "language": { search: '', searchPlaceholder: "Search..." },
        "order": [],
        "columnDefs": [ { "orderable": false, "targets": [0] },
            { "orderable": true, "targets": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15] } ]
    });

    
    $(".dataTables_filter input").css("background-image", "url('http://127.0.0.1:8000/theme/images/search-icon.png')");

});


function updateStatus(url,user_id,status,token){
    $.ajax({
        url: url,
        type: 'POST',
        data: { user_id:user_id, status:status, _token:token }
    });
}

