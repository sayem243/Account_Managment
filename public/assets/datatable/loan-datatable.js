$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var dataTable= $('.loan_table').DataTable( {

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
            "url": "/loan/datatable", // ajax source
            'data': function(data){

                var loan_generate_id = $('#loan_generate_id').val();
                var from_company_id = $('#from_company_id').val();
                var to_company_id = $('#to_company_id').val();


                // Read values
                data._token = CSRF_TOKEN;
                data.loan_generate_id = loan_generate_id;
                data.from_company_id = from_company_id;
                data.to_company_id = to_company_id;
            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'name' },
            { "name": 'loanDate' },
            { "name": 'pMode' },
            { "name": 'loanFromRefId' },
            { "name": 'loanToRefId' },
            { "name": 'amount' },
            { "name": '' },
        ],
        "order": [
            [1, "asc"]
        ],// set first column as a default sort by asc
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            },
            {
                "targets": 7,
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
            $( api.column( 6 ).footer() ).html( parseFloat(pageTotal).toFixed(2) );
        }

    });


    $('#loan_generate_id').keyup(function(){
        dataTable.draw();
    });

    $('#from_company_id').change(function(){
        dataTable.draw();
    });
    $('#to_company_id').change(function(){
        dataTable.draw();
    });



});

