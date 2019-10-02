@extends('admin.index')
@section('title','Voucher Entry')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Voucher Entry </h5>

                    <div class="card-header-right">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                            <a href="{{route('voucher_create')}}" class="btn btn-sm  btn-info"><i class="fas fa-sign-out-alt"></i>Add New</a>
                        </div>

                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle btn-more" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-original-title="" title="">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>

                            </ul>
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

                    <div class="card-block">
                        <div class="card-body">

                            <form class="form-horizontal" action="{{ route('voucher_store')}}" method="post" enctype="multipart/form-data">

                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id" class="">User Name</label>
                                            <select class="form-control js-example-basic-single" name="user_id" id="voucher_user" required input id="myInput" type="text"  placeholder="Search..">

                                                    <option value="">Select User</option>
                                                        @foreach($users as $user)
                                                        <option value="{{$user->id}}"> {{$user->name}} </option>

                                                    @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="comments">Comments</label>
                                            <textarea name="comments" rows="3.5" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <table class="table table-bordered voucher">
                                    <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Project</th>
                                        <th>Total Paid Amount</th>
                                        <th>Received Amount</th>
                                        <th>File</th>
                                        <td>Action</td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <div class="col-sm-12 col-form-label" align="right">
                                        <input type="button" class="btn btn-info add-row" value="Add Row">
                                    </div>

                                    <tr>
                                        <td>
                                            <select class="form-control user_payment_list" name="payment_id[]" required>
                                                <option value="">Select Payment ID</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select class="form-control payment_project_list" name="project_id[]" required>
                                                <option value="">Select Project</option>
                                            </select>
                                        </td>

                                        <td class="paid">

                                        </td>


                                        <td>
                                            <input type="text" class="form-control demand_amount" name="amount[]" id="amount" required>
                                        </td>
                                        <td>

                                            <input type="file" class="form-control" name="filenames[]" id="filenames" placeholder="">
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-danger hide">Delete </button>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <div class="line aligncenter">

                                    {{--<div class="form-group row">--}}
                                        {{--<label for="file" class="col-sm-2 col-form-label">File :</label>--}}
                                        {{--<div class="col-sm-10">--}}
                                            {{--<input type="file" class="form-control" name="file" id="file" placeholder="">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}



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

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    {{--<script src="{{asset('assets/plugins/select2/js/select2.full.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/js/select2.js')}}"></script>--}}

    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $(".add-row").on('click', function(){
                var table = $('.voucher');
                var nrow = table.find('tr:eq(1)').clone();
                nrow.find('td').find('button').removeClass('hide');
                table.append(nrow);
            });

            // Find and remove selected table rows
            $('body').on('click','.btn', function(){
                $(this).closest("tr").remove();
            });
        });


        $(document).ready(function(){
            $('.js-example-basic-single').select2();
        });


    </script>





@endsection



