$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var dataTable= $('.check_registry').DataTable( {

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
            "url": "/check/registry/datatable", // ajax source
            'data': function(data){

                var check_number = $('#check_number').val();
                var company_id = $('#company_id').val();
                var bank_id = $('.bank_id').val();
                var branch_id = $('.branch_id').val();
                var bank_account_id = $('.bank_account_id').val();
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();


                // Read values
                data._token = CSRF_TOKEN;
                data.check_number = check_number;
                data.company_id = company_id;
                data.bank_id = bank_id;
                data.branch_id = branch_id;
                data.bank_account_id = bank_account_id;
                data.from_date = from_date;
                data.to_date = to_date;

            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'name' },
            { "name": 'checkDate' },
            { "name": 'createdAtForSort' },
            { "name": 'companyName' },
            { "name": 'amount' },
            { "name": 'checkType' },
            { "name": 'checkMode' },
            { "name": '' },
        ],
        "order": [
            [3, "desc"]
        ],// set first column as a default sort by asc
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            },
            {
                "targets": [ 3 ],
                "visible": false
            },
            {
                "targets": 8,
                "orderable": false
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
            $( api.column( 5 ).footer() ).html( parseFloat(pageTotal).toFixed(2) );
        }

    });


    $('#check_number').keyup(function(){
        dataTable.draw();
    });

    $('#company_id').change(function(){
        dataTable.draw();
    });

    $('.bank_id').change(function(){
        dataTable.draw();
    });

    $('.branch_id').change(function(){
        dataTable.draw();
    });

    $('.bank_account_id').change(function(){
        dataTable.draw();
    });

    $('.date_picker').change(function(){
        dataTable.draw();
    });

});

