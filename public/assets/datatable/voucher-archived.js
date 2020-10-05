$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.fn.dataTable.ext.buttons.all_voucher = {
        className: 'buttons-alert voucher_status',
    };

    var dataTable= $('#voucher_table').DataTable( {

        loadingMessage: 'Loading...',
        "processing": false,
        "serverSide": true,
        "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.
        'searching': false,
        "lengthMenu": [
            [10, 20, 50, 100, 150, -1],
            [10, 20, 50, 100, 150, "All"] // change per page values here
        ],
        "pageLength": 50, // default record count per page
        "ajax": {
            "type"   : "POST",
            "cache": false,
            "url": '/voucher/archived/datatable', // ajax source
            'data': function(data){
                // Read values
                var item_expenditure_sector = $('.item_expenditure_sector').val();
                var project_id = $('#project_id').val();
                var voucher_id = $('#voucher_id').val();
                var company_id = $('#company_id').val();
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                var voucher_status = $('.payment_table').find('.active').attr('data-status');


                data._token = CSRF_TOKEN;
                data.voucher_id = voucher_id;
                data.expenditure_sector = item_expenditure_sector;
                data.project_id = project_id;
                data.company_id = company_id;
                data.from_date = from_date;
                data.to_date = to_date;
                data.voucher_status = voucher_status?voucher_status:'all';
            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'createdAt' },
            { "name": 'createdAtForSort' },
            { "name": 'name' },
            { "name": 'pId' },
            { "name": 'companyName' },
            { "name": 'projectName' },
            { "name": 'amount' },
            { "name": '' },
            { "name": '' },
        ],
        "order": [
            [2, "desc"]
        ],// set first column as a default sort by asc
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            },
            {
                "targets": [2],
                "visible": false
            },
            {
                "targets": 8,
                "orderable": false
            },
            {
                "targets": 9,
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
                    'data-status': 'all'
                }
            },
            {
                extend: 'all_voucher',
                text: 'Created',
                className: 'buttons-alert voucher_status btn-info',
                attr:  {
                    title: 'Created',
                    'data-status': 1
                }
            },
            {
                extend: 'all_voucher',
                text: 'Approved',
                className: 'buttons-alert voucher_status btn-info',
                attr:  {
                    title: 'Approved',
                    'data-status': 2
                }
            },
            {
                extend: 'all_voucher',
                text: 'Question',
                className: 'buttons-alert voucher_status btn-info',
                attr:  {
                    title: 'Question',
                    'data-status': 3
                }
            },
            {
                extend: 'all_voucher',
                text: 'Archived',
                className: 'buttons-alert voucher_status btn-info',
                attr:  {
                    title: 'Archived',
                    'data-status': 4
                }
            }
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 7 ).footer() ).html( parseFloat(pageTotal).toFixed(2) );
        }
    });
    $('#voucher_id').keyup(function(){
        dataTable.draw();
    });
    $('#company_id').change(function(){
        dataTable.draw();
    });
    $('#project_id').change(function(){
        dataTable.draw();
    });

    $('.item_expenditure_sector').change(function(){
        dataTable.draw();
    });

    $('.date_picker').change(function(){
        dataTable.draw();
    });

    $('.voucher_status').on('click', function(){
        $('.voucher_status').removeClass('active');
        $(this).addClass('active');
        dataTable.draw();
    });


    jQuery("body").on("click",".voucher_approved",function(e){
        var element = e.target;
        e.preventDefault();
        var id = jQuery(this).attr('data-id');
        var voucher_status = jQuery(this).attr('data-status');
        if(id===''){
            return false;
        }
        if (confirm("Are you sure ?")) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/ajax/voucher/approved/' + id,
                data: {
                    voucher_status:voucher_status
                },
                success: function (data) {
                    if (data.status == 200) {
                        jQuery('.alert').removeClass('alert-danger').addClass('alert-success').show();
                        jQuery('.alert').find('.message').html(data.message);
                        dataTable.draw();
                    }else{
                        jQuery('.alert').removeClass('alert-success').addClass('alert-danger').show();
                        jQuery('.alert').find('.message').html(data.message);
                        dataTable.draw();
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                    }
                }
            });
        }
    });

    jQuery("body").on("click",".voucher_seen_unseen",function(e){
        var element = e.target;
        e.preventDefault();
        var id = jQuery(this).attr('data-id');
        var voucher_status = jQuery(this).attr('data-status');
        if(id===''){
            return false;
        }
        if (confirm("Are you sure ?")) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/ajax/voucher/seen/unseen/' + id,
                data: {
                    voucher_status:voucher_status
                },
                success: function (data) {
                    if (data.status == 200) {
                        jQuery('.alert').addClass('alert-success').show();
                        jQuery('.alert').find('.message').html(data.message);
                        dataTable.draw();
                    }else{
                        jQuery('.alert').addClass('alert-danger').show();
                        jQuery('.alert').find('.message').html(data.message);
                        dataTable.draw();
                    }
                }
            });
        }
    });

});

