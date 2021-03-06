@extends('layout')
@section('title','Update Payment')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Payment</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                                <a href="{{route('payment')}}" class="btn btn-sm  btn-info"><i class="fas fa-angle-double-left"></i> Back</a>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('payment_update',$payment->id)}}" method="post" enctype="multipart/form-data">

                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for=""><h4>Update: Advance Payment</h4></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="text-align: right">
                                        <label for="exampleInputEmail1"><h4 style="margin-bottom: 0">Date: {{ date('d-m-Y') }}</h4></label>
                                        <br>
                                        <label for="exampleInputEmail1">Disbursed Schedule Date: {{ date('d-m-Y', strtotime($payment->disbursed_schedule_date))}}
                                            <p style="color: red;margin-bottom: 0px;">To change please select date</p>
                                            <input type="date" class="form-control" name="disbursed_schedule_date" min="{{date("Y-m-d")}}" value="{{ date('Y-m-d', strtotime($payment->disbursed_schedule_date))}}">
                                            </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user_id">Paid To:</label>
                                        <select style="pointer-events: none;" class="form-control select2" name="user_id" id="edit_user_id" required>

                                            <option value="">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}" {{$user->id==$payment->user->id?'selected="selected"':''}}> {{$user->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Company:</label>
                                        <select style="pointer-events: none;" class="form-control js-example-basic-single" name="company_id" id="company_id" required>

                                            <option value="">Select Company</option>
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}" {{$company->id==$payment->company->id?'selected="selected"':''}}> {{$company->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="comments">Comments:</label>
                                        <textarea name="comments" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>



                            <table class="table table-bordered payment_details_table" style="margin-bottom: 0px">
                                <thead class="thead-dark">
                                <tr>
                                    <th width="30%">Project</th>
                                    <th width="40%">Item Name</th>
                                    <th style="text-align: right;padding-right: 15px" width="20%">Amount</th>
                                    <th style="text-align: right;padding-right: 15px" width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(sizeof($payment->Payment_details)>0)
                                @foreach($payment->Payment_details as $detail)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="exit_payment_detail[]" value="{{$detail->id}}">

                                            <input type="hidden" name="exit_project_id[]" value="{{$detail->project->id}}">

                                            <select class="form-control exit_user_project_list" disabled required>
                                                <option value="">Select Project</option>
                                                @foreach($projects as $project)
                                                    <option value="{{$project['id']}}" {{ $project['id']==$detail->project->id?'selected="selected"':''}}>{{$project['name']}}</option>
                                                @endforeach

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control item_name" name="exit_item_name[]" id="exit_item_name" value="{{$detail->item_name}}">
                                        </td>
                                        <td>
                                            <input style="text-align: right" type="text" class="form-control paid_amount amount" name="exit_paid_amount[]" id="paid_amount" value="{{$detail->paid_amount}}" >
                                        </td>
                                        <td style="text-align: right">
                                            <button type="button" data-id="{{$detail->id}}" class="btn btn-danger remove exit_hide">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif

                                    <tr>
                                        <td>
                                            <select class="form-control" name="project_id[]" required>
                                                <option value="0">Select Project</option>
                                                @if(sizeof($payment->Payment_details)>0)
                                                <option value="{{$detail->project->id}}">{{$detail->project->p_name}}</option>
                                                @else
                                                @foreach($projects as $project)
                                                    <option value="{{$project['id']}}">{{$project['name']}}</option>
                                                @endforeach
                                                @endif

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control item_name" name="item_name[]" id="item_name" placeholder="Item Name">
                                        </td>
                                        <td>
                                            <input style="text-align: right" type="text" class="form-control paid_amount amount" name="paid_amount[]" id="paid_amount">
                                        </td>
                                        <td style="text-align: right">
                                            <button type="button" data-id="" class="btn btn-danger remove hide">Delete</button>
                                        </td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                <tr style="font-weight: bold; font-size: 20px">
                                    <td colspan="2" align="right" style="padding-right: 20px">Total:</td>
                                    <td colspan="" class="total_amount" align="right" style="padding: 10px 20px"></td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="row">
                                <div style="padding-right: 5px" class="col-sm-12 col-form-label" align="right">
                                    <button style="margin-right: 0" type="button" class="btn btn-info btn-sm add-row"><i class="fa fa-plus" aria-hidden="true"></i> Add Row</button>
                                </div>
                            </div>
                            <div class="line aligncenter" style="float: right">
                                <div class="form-group row">
                                    <div style="padding-right: 3px" class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                        <button style="margin-right: 0" type="submit" class="btn btn-info btn-lg" data-original-title="" title=""> <i class="feather icon-save"></i> Save</button>
                                        {{--<button type="reset" class="btn btn btn-outline-danger" data-original-title="" title=""> <i class="feather icon-refresh-ccw"></i> Cancel</button>--}}
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
    <script type="text/javascript">
        $(document).ready(function(){

            $(".add-row").on('click', function(){
                var table = $('.payment_details_table tbody');
                var nrow = table.find('tr').last().clone();
                nrow.find('td').find('button').removeClass('hide');
                nrow.find("input[type=text]").val("");
                table.append(nrow);
            });

            // Find and remove selected table rows
            $('body').on('click','.remove', function(){
                // $(this).closest("tr").remove();
                var elements = jQuery(this);
                var id = jQuery(this).attr('data-id');
                if(id===''){
                    $(this).closest("tr").remove();
                    return false;
                }
                if(confirm("Do You want to Delete?")) {
                    jQuery.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: '/payment/details/delete/' + id,
                        data: {},
                        success: function (data) {
                            if (data.status == 200) {
                                jQuery(elements).closest("tr").remove();
                                calculateSum();
                            }

                        },
                        error: function(data) {
                            console.log(data);
                        },
                    });
                }
            });
        });


        jQuery(document).ready(function(){
            calculateSum();
            jQuery(document).on('keyup','.amount', function () {
                calculateSum();
            })
        });

        $(document).on("keypress keyup blur", ".amount", function (e) {
            $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        function calculateSum() {

            var sum = 0;
            $(".amount").each(function() {
                if(!isNaN(this.value) && this.value.length!=0) {
                    sum += parseFloat(this.value);
                }
            });
            $('.total_amount').text(sum);
        }
    </script>
@endsection


