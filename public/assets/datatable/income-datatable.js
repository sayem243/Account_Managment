$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var dataTable= $('.income_table').DataTable( {

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
            "url": "/income/datatable", // ajax source
            'data': function(data){

                var income_generate_id = $('#income_generate_id').val();
                var company_id = $('#company_id').val();

                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                // Read values
                data._token = CSRF_TOKEN;
                data.income_generate_id = income_generate_id;
                data.company_id = company_id;
                data.from_date = from_date;
                data.to_date = to_date;

            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'name' },
            { "name": 'incomeDate' },
            { "name": 'pMode' },
            { "name": 'companyName' },
            { "name": 'incomeFromRefId' },
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


    $('#income_generate_id').keyup(function(){
        dataTable.draw();
    });

    $('#company_id').change(function(){
        dataTable.draw();
    });
    $('.date_picker').change(function(){
        dataTable.draw();
    });



});

