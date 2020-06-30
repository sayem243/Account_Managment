$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.fn.dataTable.ext.buttons.all_voucher = {
        className: 'buttons-alert voucher_status',

    };
    var dataTable= $('.table').DataTable( {

        loadingMessage: 'Loading...',
        "processing": false,
        "serverSide": true,
        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
        'searching': false,
        "lengthMenu": [
            [10, 20, 50, 100, 150, -1],
            [10, 20, 50, 100, 150, "All"] // change per page values here
        ],
        "pageLength": 50, // default record count per page
        "ajax": {
            "type"   : "POST",
            "cache": false,
            "url": "/voucher/item/datatable", // ajax source
            'data': function(data){
                // Read values
                var project_id = $('#project_id').val();
                var payment_id = $('#payment_id').val();
                var voucher_status = $('.voucher_item_table').find('.active').attr('data-status');

                data._token = CSRF_TOKEN;
                data.payment_id = payment_id;
                data.project_id = project_id;
                data.voucher_status = voucher_status;
            }
        },
        'columns': [
            { "name": '' },
            { "name": '' },
            { "name": 'name' },
            { "name": 'pId' },
            { "name": 'projectName' },
            { "name": 'amount' },
        ],
        "order": [
            [2, "asc"]
        ],// set first column as a default sort by asc
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            },
            {
                "targets": 1,
                "orderable": false
            },
            {
                "targets": 5,
                "orderable": false
            }],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'all_voucher',
                text: 'All',
                className: 'buttons-alert voucher_status btn-info',
                attr:  {
                    title: 'All',
                    'data-status': 0
                }
            },
            {
                extend: 'all_voucher',
                text: 'Archived',
                className: 'buttons-alert voucher_status btn-info',
                attr:  {
                    title: 'Archived',
                    'data-status': 1
                }
            }
        ]
    });
    $('#payment_id').keyup(function(){
        dataTable.draw();
    });

    $('#project_id').change(function(){
        dataTable.draw();
    });


    $('.voucher_status').on('click', function(){
        $('.voucher_add_button').show();
        if($(this).attr('data-status')==1){
            $('.voucher_add_button').hide();
        }
        $('.voucher_status').removeClass('active');
        $(this).addClass('active');
        dataTable.draw();
    });

});

