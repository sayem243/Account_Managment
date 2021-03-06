$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var dataTable= $('#payment_settlement_table').DataTable( {

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
            "url": '/payment/settlement/datatable', // ajax source
            'data': function(data){
                // Read values
                var project_id = $('#project_id').val();
                var company_id = $('#company_id').val();
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                data._token = CSRF_TOKEN;
                data.project_id = project_id;
                data.company_id = company_id;
                data.from_date = from_date;
                data.to_date = to_date;
            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'pId' },
            { "name": 'companyName' },
            { "name": 'projectName' },
            { "name": 'amount' },
        ],
        "order": [
            [1, "asc"]
        ],// set first column as a default sort by asc
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            }
            ],
    });
    $('#company_id').change(function(){
        dataTable.draw();
    });
    $('#project_id').change(function(){
        dataTable.draw();
    });

    $('.date_picker').change(function(){
        dataTable.draw();
    });

});

