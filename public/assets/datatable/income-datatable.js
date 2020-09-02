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

                // Read values
                data._token = CSRF_TOKEN;

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

    });


    $('#check_number').keyup(function(){
        dataTable.draw();
    });

    $('#company_id').change(function(){
        dataTable.draw();
    });



});

