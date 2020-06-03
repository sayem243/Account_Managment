@extends('admin.index')
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
                                        <label for="exampleInputEmail1"><h4>Create: Advance Payment</h4></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="text-align: right">
                                        <label for="exampleInputEmail1"><h4>Date: {{ date('d-m-Y') }}</h4></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id">Paid To:</label>
                                        <select class="form-control" name="user_id" id="user_id" required>

                                            <option value="">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}" {{$user->id==$payment->user->id?'selected="selected"':''}}> {{$user->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="comments">Comments:</label>
                                        <textarea name="comments" rows="4" class="form-control">{{$payment->comments}}</textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-12 col-form-label" align="right">
                                <input type="button" class="btn btn-info add-row" value="Add Row">
                            </div>
                            <table class="table table-bordered payment_details_table">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Project</th>
                                    <th>Item Name</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payment->Payment_details as $detail)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="exit_payment_detail[]" value="{{$detail->id}}">

                                            <select class="form-control exit_user_project_list" name="exit_project_id[]" required>
                                                <option value="">Select Project</option>
                                                @foreach($payment->user->projects as $project)
                                                    <option value="{{$project->id}}" {{ $project->id==$detail->project->id?'selected="selected"':''}}>{{$project->p_name}}</option>
                                                @endforeach

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control item_name" name="exit_item_name[]" id="exit_item_name" value="{{$detail->item_name}}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control paid_amount" name="exit_paid_amount[]" id="paid_amount" value="{{$detail->paid_amount}}" >
                                        </td>
                                        <td>
                                            <button type="button" data-id="{{$detail->id}}" class="btn btn-danger remove exit_hide">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach

                                    <tr>
                                        <td>
                                            <select class="form-control user_project_list" name="project_id[]" required>
                                                <option value=""></option>

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control item_name" name="item_name[]" id="item_name" placeholder="Item Name">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control paid_amount" name="paid_amount[]" id="paid_amount">
                                        </td>
                                        <td>
                                            <button type="button" data-id="" class="btn btn-danger remove hide">Delete</button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                            <div class="line aligncenter">
                                <div class="form-group row">
                                    <div class="col-sm-12 col-form-label" align="right">
                                        <button type="submit" class="btn purple-bg white-font" data-original-title="" title=""> <i class="feather icon-save"></i>Save</button>
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
    {{--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>--}}
    <script type="text/javascript">
        $(document).ready(function(){

            $(".add-row").on('click', function(){
                var table = $('.payment_details_table');
                var nrow = table.find('tr').last().clone();
                nrow.find('td').find('button').removeClass('hide');
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
                            }

                        },
                        error: function(data) {
                            console.log(data);
                        },
                    });
                }
            });
        });
    </script>
@endsection


