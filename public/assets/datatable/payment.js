$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.fn.dataTable.ext.buttons.all_payment = {
        className: 'buttons-alert payment_status',

    };
    var payment_table_element = $('.payment_table');
    var dataTable= $('.table').DataTable( {

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
            "url": "/payment/datatable", // ajax source
            'data': function(data){
                // Read values
                var item_search = $('#item_search').val();
                var payment_id = $('#payment_id').val();
                var company_id = $('#company_id').val();
                var user_id = $('#user_id').val();
                var project_id = $('#project_id').val();

                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                var payment_status = $('.payment_table').find('.active').attr('data-status');
                var payment_date_age_to = payment_table_element.find('.date_range_active').attr('data-date-range-to');
                var payment_date_age_from = payment_table_element.find('.date_range_active').attr('data-date-range-from');
                // Append to data
                data._token = CSRF_TOKEN;
                data.payment_id = payment_id;
                data.company_id = company_id;
                data.user_id = user_id;
                data.project_id = project_id;
                data.payment_status = payment_status?payment_status:'all';
                data.from_date = from_date;
                data.to_date = to_date;
                data.item_search = item_search;
                data.payment_date_age_to = payment_date_age_to;
                data.payment_date_age_from = payment_date_age_from;
            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'created_at' },
            { "name": 'updated_at' },
            { "name": 'name' },
            { "name": 'companyName' },
            { "name": 'amount' },
            { "name": 'pStatus' },
            { "name": '' },
            { "name": '' },
            { "name": '' },
        ],
        "order": [
            [2, "desc"]
        ],// set first column as a default sort by asc
        "columnDefs": [ {
            "targets": 8,
            "orderable": false
        },{
            "targets": 9,
            "orderable": false
        },
        {
            "targets": 7,
            "orderable": false
        },
        {
            "targets": [2],
            "visible": false
        },
        {
            "targets": 0,
            "orderable": false
        }
            ],
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
                text: 'Partial Settle',
                className: 'buttons-alert payment_status btn-info',
                attr:  {
                    title: 'Partial Settle',
                    'data-status': 5
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
                extend: 'all_payment',
                text: 'Park',
                className: 'buttons-alert payment_status btn-info park_button',
                attr:  {
                    title: 'Park',
                    'data-status': 7
                }
            },
            {
                extend: 'collection',
                text: 'Age of HS',
                className: 'buttons-alert payment_date_range btn-info',
                buttons: [
                    {
                        text: '0-30 days',
                        className: 'payment_date_age payment_date_age_30',
                        attr:  {
                            title: '0-30 days',
                            'data-date-range-to': calculateDate('current'),
                            'data-date-range-from': calculateDate('past_30')
                        }
                    },
                    {
                        text: '30-60 days',
                        className: 'payment_date_age payment_date_age_60',
                        attr:  {
                            title: '30-60 days',
                            'data-date-range-to': calculateDate('past_30'),
                            'data-date-range-from': calculateDate('past_60')
                        }
                    },
                    {
                        text: '60-90 days',
                        className: 'payment_date_age payment_date_age_90',
                        attr:  {
                            title: '60-90 days',
                            'data-date-range-to': calculateDate('past_60'),
                            'data-date-range-from': calculateDate('past_90')
                        }
                    },
                    {
                        text: '90+ days',
                        className: 'payment_date_age payment_date_age_90',
                        attr:  {
                            title: '90+ days',
                            'data-date-range-to': calculateDate('past_90'),
                            'data-date-range-from': '2020-01-01'
                        }
                    }
                ]
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
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 6 ).footer() ).html( parseFloat(pageTotal).toLocaleString());
        },
        rowCallback: function (row, data) {
            console.log(data[10]);
        if(data[10]===1){
            $(row).addClass('cash_check_voucher_item');
        }
    }
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
    });

    $('#item_search').keyup(function(){
        dataTable.draw();
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
        payment_table_element.find('.payment_date_age').removeClass('date_range_active');
        $('.payment_status').removeClass('active');
        $(this).addClass('active');
        dataTable.draw();
    });

    payment_table_element.on('click', '.payment_date_age', function(){
        payment_table_element.find('.payment_status').removeClass('active');
        payment_table_element.find('.payment_date_age').removeClass('date_range_active');
        $(this).addClass('date_range_active');

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
                        $(".notification_count").load("/notification/refresh");
                    }else{
                        jQuery('.alert').addClass('alert-danger').show();
                        jQuery('.alert').find('.message').html(data.message);
                        dataTable.draw();
                    }
                }
            });
        }
    });

    jQuery("body").on("click",".un_park",function(e){
        var element = e.target;
        e.preventDefault();
        var id = jQuery(this).attr('data-id');
        var payment_status = jQuery(this).attr('data-status');
        if (confirm("Are you sure ?")) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/payment/status/unpark/' + id,
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
                        $(".notification_count").load("/notification/refresh");
                    }else{
                        jQuery('.alert').addClass('alert-danger').show();
                        jQuery('.alert').find('.message').html(data.message);
                        dataTable.draw();
                    }
                }

            });
        }
    });



    function calculateDate(dateType) {

        var today = new Date();

        if(dateType==='current'){
            return today.toISOString().substring(0, 10);
        }

        if(dateType==='past_30'){
            today.setDate(today.getDate() - 30);
            return today.toISOString().split('T')[0];
        }

        if(dateType==='past_60'){
            today.setDate(today.getDate() - 60);
            return today.toISOString().split('T')[0];
        }

        if(dateType==='past_90'){
            today.setDate(today.getDate() - 90);
            return today.toISOString().split('T')[0];
        }

    }




});

