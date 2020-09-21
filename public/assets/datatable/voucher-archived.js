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
                var company_id = $('#company_id').val();
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                data._token = CSRF_TOKEN;
                data.voucher_id = voucher_id;
                data.project_id = project_id;
                data.company_id = company_id;
                data.from_date = from_date;
                data.to_date = to_date;
            }
        },
        'columns': [
            { "name": 'id' },
            { "name": 'createdAt' },
            { "name": 'name' },
            { "name": 'pId' },
            { "name": 'companyName' },
            { "name": 'projectName' },
            { "name": 'amount' },
            { "name": '' },
            { "name": '' },
        ],
        "order": [
            [1, "desc"]
        ],// set first column as a default sort by asc
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            },
            {
                "targets": 7,
                "orderable": false
            },
            {
                "targets": 8,
                "orderable": false
            }],
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
            $( api.column( 7 ).footer() ).html( parseFloat(pageTotal).toFixed(2) );
        }
    });
    $('#voucher_id').keyup(function(){
        dataTable.draw();
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


    jQuery("body").on("click",".voucher_approved",function(e){
        var element = e.target;
        e.preventDefault();
        var id = jQuery(this).attr('data-id');
        var voucher_status = jQuery(this).attr('data-status');
        if(id===''){
            return false;
        }
        if (confirm("Are you sure ?")) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/ajax/voucher/approved/' + id,
                data: {
                    voucher_status:voucher_status
                },
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

});

