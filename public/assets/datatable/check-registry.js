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


                // Read values
                data._token = CSRF_TOKEN;
                data.check_number = check_number;
                data.company_id = company_id;

            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'name' },
            { "name": 'checkDate' },
            { "name": 'companyName' },
            { "name": 'amount' },
            { "name": 'checkType' },
            { "name": 'checkMode' },
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
                "targets": 6,
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

