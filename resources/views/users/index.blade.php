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
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Roles</th>

                                <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                                    <i class="feather icon-settings"></i>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td> {{$user->UserProfile['fname'].' '.$user->UserProfile['lname']}}</td>
                                    <td>{{$user->UserProfile->company['name']}}</td>
                                    <td>{{ $user->email }}</td>


                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>

{{--                                    <td>--}}
{{--                                        <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>--}}
{{--                                        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>--}}
{{--                                        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}--}}
{{--                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}--}}
{{--                                        {!! Form::close() !!}--}}
{{--                                    </td>--}}

                                  
                                    <td>
                                        <div class="btn-group card-option">
                                            <button type='button' class='btn btn-notify' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-ellipsis-v'></i></button>
                                            <ul class='list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right' x-placement='bottom-end'>

                                                <li class="dropdown-item">
                                                    <a href="{{route('userprofile_show',$user->id)}}">
                                                        <i class="feather icon-eye"></i>
                                                        Details</a>
                                                </li>

                                                <li class="dropdown-item">
                                                    <a href="{{route('users.show',$user->id)}}">
                                                        <i class="feather icon-eye"></i>
                                                        Role-Show</a>
                                                </li>
                                                @if(auth()->user()->hasRole('superadmin'))
                                                <li class="dropdown-item">
                                                    <a href="{{route('userprofileEdit',$user->id)}}">
                                                        <i class="feather icon-edit"></i>
                                                        Edit</a>
                                                </li>
                                                @endif
                                                @if(auth()->user()->hasRole('superadmin'))
                                                <li class="dropdown-item">
                                                    <a href="{{route('User_delete',$user->id)}}">
                                                        <i class="feather icon-trash-2"></i>
                                                        Remove</a>
                                                </li>
                                                @endif
                                                @if(auth()->user()->hasRole('superadmin') || auth()->user()->id == $user->id)
                                                <li class="dropdown-item">
                                                    <a href="{{route('password-change',$user->id)}}">
                                                        <i class="feather icon-edit"></i>
                                                        Password Change</a>
                                                </li>
                                                @endif

                                            </ul>
                                        </div>

                                    </td>
                                </tr>

                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                            {{--{!! $data->render() !!}--}}
                    </div>
                    <ul class="pagination justify-content-end">
                        {{$data->render('vendor.pagination.bootstrap-4')}}
                    </ul>

                </div>
            </div>
        </div>
    </div>




@endsection