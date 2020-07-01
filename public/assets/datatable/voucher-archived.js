$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var dataTable= $('#voucher_table').DataTable( {

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
            "url": '/voucher/archived/datatable', // ajax source
            'data': function(data){
                // Read values
                var project_id = $('#project_id').val();
                var voucher_id = $('#voucher_id').val();

                data._token = CSRF_TOKEN;
                data.voucher_id = voucher_id;
                data.project_id = project_id;
            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'name' },
            { "name": 'pId' },
            { "name": 'companyName' },
            { "name": 'projectName' },
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
                "targets": 6,
                "orderable": false
            }],
    });
    $('#voucher_id').keyup(function(){
        dataTable.draw();
    });

    $('#project_id').change(function(){
        dataTable.draw();
    });


});

