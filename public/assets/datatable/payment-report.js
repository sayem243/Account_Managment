$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.fn.dataTable.ext.buttons.all_payment = {
        className: 'buttons-alert payment_status',

    };
    var dataTable= $('.table').DataTable( {

        loadingMessage: 'Loading...',
        "processing": false,
        "paging": true,
        "serverSide": true,
        "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.
        'searching': false,
        "lengthMenu": [
            [10, 20, 50, 100, 150, -1],
            [10, 20, 50, 100, 150, "All"] // change per page values here
        ],
        "pageLength": 100, // default record count per page
        "ajax": {
            "type"   : "POST",
            "cache": false,
            "url": "/report/payment/datatable", // ajax source
            'data': function(data){
                // Read values
                var payment_id = $('#payment_id').val();
                var company_id = $('#company_id').val();
                var user_id = $('#user_id').val();
                var project_id = $('#project_id').val();

                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                var payment_status = $('.payment_table').find('.active').attr('data-status');
                // Append to data
                data._token = CSRF_TOKEN;
                data.payment_id = payment_id;
                data.company_id = company_id;
                data.user_id = user_id;
                data.project_id = project_id;
                data.payment_status = payment_status?payment_status:'all';
                data.from_date = from_date;
                data.to_date = to_date;
            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'created_at' },
            { "name": 'name' },
            { "name": 'companyName' },
            { "name": 'amount' },
            { "name": 'pStatus' },
        ],
        "order": [
            [1, "asc"]
        ],// set first column as a default sort by asc
        "columnDefs": [
            {
                "targets": 6,
                "orderable": false
            },
            {
                "targets": 0,
                "orderable": false
            }],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'all_payment',
                text: 'All',
                className: 'buttons-alert payment_status btn-info',
                attr:  {
                    title: 'All',
                    'data-status': 'all'
                }
            },
            {
                extend: 'all_payment',
                text: 'Created',
                className: 'buttons-alert payment_status btn-info',
                attr:  {
                    title: 'Created',
                    'data-status': 1
                }
            },
            {
                extend: 'all_payment',
                text: 'Verified',
                className: 'buttons-alert payment_status btn-info',
                attr:  {
                    title: 'Verified',
                    'data-status': 2
                }
            },
            {
                extend: 'all_payment',
                text: 'Approved',
                className: 'buttons-alert payment_status btn-info',
                attr:  {
                    title: 'Approved',
                    'data-status': 3
                }
            },
            {
                extend: 'all_payment',
                text: 'Disbursed',
                className: 'buttons-alert payment_status btn-info',
                attr:  {
                    title: 'Disbursed',
                    'data-status': 4
                }
            },
            {
                extend: 'all_payment',
                text: 'Archived',
                className: 'buttons-alert payment_status btn-info',
                attr:  {
                    title: 'Archived',
                    'data-status': 6
                }
            },
            {
                extend: 'collection',
                text: 'Export',
                className: 'd-none',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            },

        ],
        /*"buttons": [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            },
            {
                text: 'Reload',
                className: 'btn default',
                action: function ( e, dt, node, config ) {
                    dt.ajax.reload();
                    alert('Datatable reloaded!');
                }
            }
        ]*/
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
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
                pageTotal
            );
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

    $('#user_id').change(function(){
        dataTable.draw();
    });

    $('.date_picker').change(function(){
        dataTable.draw();
    });

    $('.payment_status').on('click', function(){
        $('.payment_status').removeClass('active');
        $(this).addClass('active');
        dataTable.draw();
    });


    $("#csvBtn").on("click", function() {
        dataTable.button( '.buttons-csv' ).trigger();
    });

    $("#printBtn").on("click", function() {
        dataTable.button( '.buttons-print' ).trigger();
    });

    $("#excelBtn").on("click", function() {
        dataTable.button( '.buttons-excel' ).trigger();
    });

    $("#pdfBtn").on("click", function() {
        dataTable.button( '.buttons-pdf' ).trigger();
    });

    jQuery("body").on("click",".verify",function(e){
        var element = e.target;
        e.preventDefault();
        var id = jQuery(this).attr('data-id');
        var payment_status = jQuery(this).attr('data-status');
        if (confirm("Are you sure ?")) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/payment/status/' + id,
                data: {'payment_status':payment_status},
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


    jQuery(document).on("click",".approved",function(a){
        var elements = a.target;
        a.preventDefault();
        var id = jQuery(this).attr('data-id-id');
        if(confirm("Do You want to Approve ?")) {

            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/payment/status/approve/' + id,
                data: {},
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

