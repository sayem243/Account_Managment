$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var dataTable= $('.table').DataTable( {

        loadingMessage: 'Loading...',
        "processing": true,
        "serverSide": true,
        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
        'searching': false,
        "lengthMenu": [
            [10, 20, 50, 100, 150, -1],
            [10, 20, 50, 100, 150, "All"] // change per page values here
        ],
        "pageLength": 10, // default record count per page
        "ajax": {
            "type"   : "POST",
            "url": "/payment/datatable", // ajax source
            'data': function(data){
                // Read values
                var payment_id = $('#payment_id').val();
                var company_id = $('#company_id').val();
                var user_id = $('#user_id').val();
                var project_id = $('#project_id').val();

                // Append to data
                data._token = CSRF_TOKEN;
                data.payment_id = payment_id;
                data.company_id = company_id;
                data.user_id = user_id;
                data.project_id = project_id;
            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'created_at' },
            { "name": 'name' },
            { "name": 'companyName' },
            { "name": 'amount' },
            { "name": 'creatorName' },
            { "name": 'pStatus' },
        ],
        "order": [
            [1, "asc"]
        ],// set first column as a default sort by asc
        "columnDefs": [ {
            "targets": 9,
            "orderable": false
        },
            {
                "targets": 8,
                "orderable": false
            },
            {
                "targets": 7,
                "orderable": false
            },
            {
                "targets": 0,
                "orderable": false
            }],
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
                    if (data.status == 100) {
                        {
                            dataTable.draw();
                        }
                    }
                }

            });
        }
    });



});

