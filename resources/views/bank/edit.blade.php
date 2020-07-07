@extends('layout')
@section('title','Update Bank')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Bank</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                                <a href="{{route('bank_index')}}" class="btn btn-info"><i class="fa fa-angle-double-left"></i> Back</a>
                            </div>
                        </div>
                    </div>

                        <div class="card-body">

                            <form class="form-horizontal" action="{{ route('bank_update',$bank->id)}}"  method="post"  enctype="multipart/form-data">

                                {{ csrf_field() }}
                                {{--error showing --}}

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-form-label" for="name">Bank Name <span class="required">*</span></label>
                                            <div class="col-form-label">
                                                <input type="text" class="form-control" name="name" id="name" value="{{$bank->name}}" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered branch_table" style="margin-top: 25px; margin-bottom: 0">
                                            <thead>
                                            <tr>
                                                <th>Branch Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(sizeof($bank->branches)>0)
                                                @foreach($bank->branches as $branch)

                                                <tr class="{{$branch->deleted_at!=null?'deleted_item':''}}">
                                                    <td>
                                                        <input type="hidden" class="form-control branch_phone" name="branch_id[]" value="{{$branch->id}}">
                                                        <input type="text" class="form-control branch_name" name="branch_name[]" value="{{$branch->name}}" required>
                                                    </td>
                                                    <td><input type="text" class="form-control branch_phone" name="branch_phone[]" value="{{$branch->phone}}"></td>
                                                    <td><input type="text" class="form-control branch_email" name="branch_email[]" value="{{$branch->email}}"></td>
                                                    <td><input type="text" class="form-control branch_address" name="branch_address[]" value="{{$branch->address}}"></td>
                                                    <td>
                                                        @if($branch->deleted_at==null)
                                                        <button type="button" data-id="{{$branch->id}}" class="btn btn-danger remove_row">Delete</button>
                                                       @else
                                                            <a class="btn btn-danger" href="{{route('branch_restore',$branch->id)}}">
                                                                <i class="fa fa-undo" aria-hidden="true"></i>
                                                                </a>
                                                        @endif
                                                    </td>
                                                </tr>

                                            @endforeach
                                            @endif
                                            <tr>
                                                <td><input type="text" class="form-control branch_name" name="branch_name[]"></td>
                                                <td><input type="text" class="form-control branch_phone" name="branch_phone[]"></td>
                                                <td><input type="text" class="form-control branch_email" name="branch_email[]"></td>
                                                <td><input type="text" class="form-control branch_address" name="branch_address[]"></td>
                                                <td>
                                                    <button type="button" class="btn btn-info add_row">Add</button>
                                                    <button type="button" data-id="" class="btn btn-danger remove_row" style="display: none">Delete</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{--<div class="separator"></div>--}}

                                <div class="line aligncenter" style="float: right">
                                    <div class="form-group row">
                                        <div style="padding-right: 3px"
                                             class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                            <button style="margin-right: 0" type="submit" class="btn btn-info"><i
                                                        class="feather icon-save"></i> Save
                                            </button>
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
        jQuery(document).ready(function () {
            $(document).on('click', '.add_row', function(){
                var $tr = $(this).closest('tr');
                $tr.clone().insertAfter($tr);
                $tr.find('td').find('button.remove_row').show();
                $tr.find('td').find('button.add_row').hide();
                $('.branch_table tr:last').find("input[type=text]").val("");
            });

            // Find and remove selected table rows
            $('body').on('click','.remove_row', function(){
                var elements = jQuery(this);
                var id = jQuery(this).attr('data-id');
                if(id==''){
                    $(this).closest("tr").remove();
                    return false;
                }
                if(confirm("Do You want to Delete?")) {
                    jQuery.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/branch/delete/' + id,
                        data: {},
                        success: function (data) {
                            if (data.status == 200) {
                                jQuery('.alert').addClass('alert-success').show();
                                jQuery('.alert').find('.message').html(data.message);
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

