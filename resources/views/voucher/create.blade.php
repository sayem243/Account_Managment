@extends('admin.index')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Voucher Entry </h5>
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
                                            <select class="form-control" name="user_id" id="voucher_user" required>

                                                <option value="">Select User</option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}"> {{$user->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <table class="table table-bordered voucher">
                                    <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Project</th>
                                        <th>Amount </th>
                                        <td>Action</td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <div class="col-sm-12 col-form-label" align="right">
                                        <input type="button" class="btn btn-success add-row" value="Add Row">
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
                                        <td>
                                            <input type="text" class="form-control demand_amount" name="amount[]" id="amount">
                                        </td>

                                        <td>
                                            <button type="button" class="delete-row hide">Delete Row</button>
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

    </div>


    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $(".add-row").on('click', function(){
                var table = $('.voucher');
                var nrow = table.find('tr:eq(1)').clone();
                nrow.find('td').find('button').removeClass('hide');
                table.append(nrow);
            });

            // Find and remove selected table rows
            $('body').on('click','.delete-row', function(){
                $(this).closest("tr").remove();
            });
        });
    </script>





@endsection



