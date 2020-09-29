@extends('layout')
@section('title','Users List')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Users</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
{{--                                <a href="{{route('register')}}" class="btn btn-sm  btn-info">Add New</a>--}}
                                <a style="-webkit-transform: scale(0.9);" href="{{route('register')}}" class="btn btn-lg btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped table-bordered dataTable no-footer">
                            <thead class="thead-dark">
                            <tr role="row" class="filter">
                                <td colspan="2">
                                    <input  type="text" class="form-control form-filter input-sm user_name" name="user_name" id="user_name" placeholder="Employee name.....">
                                </td>
                                <td colspan="1">
                                    <select class="form-control" name="company_id" id="company_id">
                                        <option value="">All Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                {{--<th>Roles</th>--}}

                                <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                                    <i class="feather icon-settings"></i>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>

                            {{--{!! $data->render() !!}--}}
                    </div>

                </div>
            </div>
        </div>
    </div>






@endsection

@section('footer.scripts')
    <script src="{{ asset("assets/datatable/user.js") }}" ></script>
@endsection