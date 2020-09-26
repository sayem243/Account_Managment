$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.fn.dataTable.ext.buttons.all_voucher_item = {
        className: 'buttons-alert voucher_type',
    };
    var dataTable= $('#voucher_item_table').DataTable( {

        loadingMessage: 'Loading...',
        "processing": false,
        "serverSide": true,
        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
        'searching': false,
        "bPaginate": false,
        "bInfo": false,
        "lengthChange": false,
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
                var company_id = $('#company_id').val();
                var voucher_type = $('.voucher_item_table').find('.active').attr('data-status');

                data._token = CSRF_TOKEN;
                data.payment_id = payment_id;
                data.project_id = project_id;
                data.company_id = company_id;
                data.voucher_type = voucher_type;
            }
        },
        'columns': [
            { "name": '' },
            { "name": '' },
            { "name": 'name' },
            { "name": 'pId' },
            { "name": 'projectName' },
            { "name": 'amount' },
            { "name": '' },
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
                "targets": 6,
                "orderable": false
            }],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'all_voucher_item',
                text: 'Cash',
                className: 'buttons-alert payment_status voucher_type btn-info',
                attr:  {
                    title: 'Cash',
                    'data-status': 'cash'
                }
            },
            {
                extend: 'all_voucher_item',
                text: 'Cash Cheque',
                className: 'buttons-alert payment_status voucher_type btn-info',
                attr:  {
                    title: 'Cash Cheque',
                    'data-status': 'cash_cheque'
                }
            },
            {
                extend: 'all_voucher_item',
                text: 'A/C Pay Cheque',
                className: 'buttons-alert payment_status voucher_type btn-info',
                attr:  {
                    title: 'A/C Pay Cheque',
                    'data-status': 'account_pay_cheque'
                }
            },
            {
                extend: 'all_voucher_item',
                text: 'A/C Transfer',
                className: 'buttons-alert payment_status voucher_type btn-info',
                attr:  {
                    title: 'A/C Transfer',
                    'data-status': 'account_transfer_cheque'
                }
            },
        ],
        rowCallback: function (row, data) {
            if(data[7]==='CASH'){
                $(row).addClass('cash_check_voucher_item');
            }
            if(data[7]==='ACCOUNT_PAY'){
                $(row).addClass('account_pay_check_voucher_item');
            }
            if(data[7]==='ACCOUNT_TRANSFER'){
                $(row).addClass('account_pay_check_voucher_item');
            }
        }
    });
    $('#payment_id').keyup(function(){
        dataTable.draw();
    });

    $('#company_id').change(function(){
        dataTable.draw();
    });

    $('#project_id').change(function(){
        dataTable.draw();
    });
    $('.voucher_type').on('click', function(){
        $('.voucher_type').removeClass('active');
        $(this).addClass('active');
        dataTable.draw();
    });


});

