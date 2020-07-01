@extends('layout')
@section('title','Voucher Items List')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Voucher Items List</h5>
                    </div>
                    <div class="card-body" style="padding-bottom: 0">
                        <div class="dt-buttons btn-group">
                            <a style="min-width: 100px; border-radius: .3rem; font-size: 16px" href="{{route('voucher_index')}}" class="btn btn-secondary buttons-alert btn-info" title="All"><span>All</span></a>
                            <a style="min-width: 100px; border-radius: .3rem; font-size: 16px" href="{{route('voucher_archive_index')}}" class="btn btn-secondary buttons-alert btn-info" title="Created"><span>Archived</span></a>
                        </div>


                        <table class="table">
                            <thead>
                            <tr>
                                <td>Expenses Type</td>
                                <td>Project</td>
                                <td>Item Name</td>
                                <td>Amount</td>
                                <td>Action</td>
                            </tr>

                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <select name="item_expenditure_sector" class="form-control item_expenditure_sector">
                                        <option value="">Select Type</option>
                                        @foreach ($expenditureSectors as $expenditureSector)
                                            <option value="{{$expenditureSector->id}}">{{$expenditureSector->name}}</option>
                                        @endforeach

                                    </select>
                                </td>
                                <td>
                                    <select class="form-control item_project_id" name="item_project" id="item_project_id">
                                        <option value="">All Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->p_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" placeholder="Enter item name" class="form-control voucher_item_name" name="voucher_item_name"></td>
                                <td><input type="text" placeholder="Enter amount" class="form-control amount voucher_item_amount" name="voucher_item_amount"></td>
                                <td><button type="button" class="btn btn-info btn-lg add_row">Add</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body voucher_item_table payment_table" style="padding-top: 5px">


                        <form class="form-horizontal" action="{{ route('voucher_store')}}" method="post">
                            {{ csrf_field() }}
                            <table class="table table-striped table-bordered table-hover table-checkable" id="voucher_item_table">
                                <thead class="thead-dark">
                                <tr role="row" class="filter">
                                    <td colspan="2">
                                        <input  type="text" class="form-control form-filter input-sm" name="payment_id" id="payment_id" placeholder="Payment Id"> </td>

                                    </td>
                                    <td>
                                        <select class="form-control" name="project_id" id="project_id">
                                            <option value="">All Project</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->p_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td colspan="4"></td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle; width: 20px" scope="col"><input type="checkbox" class="form-control all_item"></th>
                                    <th style="width: 200px" scope="col">Expenses Type</th>
                                    <th style="width: 350px" scope="col">Item Name</th>
                                    <th style="width: 120px" width="" scope="col">HS ID</th>
                                    <th style="width: 150px" width="" scope="col">Project</th>
                                    <th style="width: 100px" width="" scope="col">Amount</th>
                                    <th style="width: 50px" width="" scope="col">Action</th>
                                </tr>

                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="line aligncenter" style="float: right">
                                <div class="form-group row">
                                    <div style="padding-right: 3px" class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                        <button onclick="return confirm('Are you sure?')" style="margin-right: 0" type="submit" class="btn btn-info btn-lg voucher_add_button" data-original-title="" title="">Next <i class="fas fa-angle-double-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer.scripts')
    <script src="{{ asset("assets/datatable/voucher-details.js") }}" ></script>

    <script type="text/javascript">
        $(document).on("keypress keyup blur", ".amount", function (e) {
            $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        jQuery(document).on("click", ".add_row", function (a) {

            var element = $(this);
            var item_expenditure_sector = element.closest('tr').find('.item_expenditure_sector').val();
            var item_project_id = element.closest('tr').find('.item_project_id').val();
            var voucher_item_name = element.closest('tr').find('.voucher_item_name').val();
            var voucher_item_amount = element.closest('tr').find('.voucher_item_amount').val();
            if(item_project_id=='' || voucher_item_amount=='' || voucher_item_name==''){
                alert('These are fields required.');
                return false;
            }


            if (confirm("Do you want to add?")) {

                jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '{{route("ajax_add_voucher_item")}}',
                    data: {
                        'expenditure_sector_id':item_expenditure_sector,
                        'project_id':item_project_id,
                        'item_name':voucher_item_name,
                        'voucher_amount':voucher_item_amount,
                    },
                    success: function (data) {

                        if(data.voucher_item_id!=''){
                            var dataOption='<select name="expenditure_sector['+data.voucher_item_id+']" class="form-control">';
                            dataOption +='<option value>Select Type</option>';
                            jQuery.each(data.expenditure_sector, function(i, item) {
                                var selected = '';
                                if(item.id==data.expenditure_sector_id){
                                   selected= 'selected="selected"';
                                }
                                dataOption += '<option value="'+item.id+'"'+selected+'>'+item.name+'</option>';
                            });
                            dataOption +='</select>';

                            var html = '<tr role="row">';
                            html +='<td><input type="checkbox" name="voucher_item[]" value="'+data.voucher_item_id+'">';
                            html +='</td>';
                            html +='<td>'+dataOption;
                            html +='</td>';
                            html +='<td><input type="hidden" value="'+data.item_name+'" name="item_name['+data.voucher_item_id+']">'+data.item_name;
                            html +='<td>';
                            html +='</td>';
                            html +='</td>';
                            html +='<td><input type="hidden" value="'+data.project_id+'" name="project_id['+data.voucher_item_id+']">'+data.project_name;

                            html +='</td>';
                            html +='<td><input type="hidden" value="'+data.voucher_amount+'" name="voucher_amount['+data.voucher_item_id+']">'+data.voucher_amount;
                            html +='</td>';
                            html +='<td><button type="button" data-id="'+data.voucher_item_id+'" class="btn btn-danger remove_row">X</button>';
                            html +='</td>';

                            html+='</tr>';

                            $(html).insertBefore('#voucher_item_table tbody > tr:first');

                        }

                    }

                });
            }
        });

        $('body').on('click','.remove_row', function(){
            var element = $(this);
            var id = element.attr('data-id');
            var url = "{{ route('voucher_item_remove', ":id") }}";
            url = url.replace(':id', id);
            if (confirm("Do you want to delete?")){
                jQuery.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: url,
                    data: {},
                    success: function (data) {
                        if(data.status==200){
                            jQuery('.alert').addClass('alert-success').show();
                            jQuery('.alert').find('.message').html(data.message);
                            element.closest("tr").remove();
                        }
                    }
                });
            }

        });



    </script>


@endsection

