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
        "pageLength": 50, // default record count per page
        "ajax": {
            "type"   : "POST",
            "url": "/user/datatable", // ajax source
            'data': function(data){
                // Read values
                var user_name = $('#user_name').val();
                var company_id = $('#company_id').val();

                data._token = CSRF_TOKEN;
                data.user_name = user_name;
                data.company_id = company_id;
            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'name' },
            { "name": 'companyName' },
            { "name": 'email' },
            { "name": '' },
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
                "targets": 4,
                "orderable": false
            },
            {
                "targets": 5,
                "orderable": false
            }
            ],
        rowCallback: function (row, data) {
            if(data[6]){
                $(row).addClass('deleted_item');
            }
        }

    });


    $('#user_name').keyup(function(){
        dataTable.draw();
    });

    $('#company_id').change(function(){
        dataTable.draw();
    });


});

