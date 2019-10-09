@extends('admin.index')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Profile</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                                <a href="{{route('register')}}" class="btn btn-sm  btn-info"><i class="fas fa-sign-out-alt"></i>Add New</a>
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

                    <div class="card-body">
                        <table class="table table-striped table-bordered dataTable no-footer">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>

                                <th>Name</th>
                                {{--<th>First Name</th>--}}
                                {{--<th>Last Name</th>--}}
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Father Name</th>
                                <th>Mother Name</th>
                                <th>Joining Date</th>
                                <th>Present Address</th>
                                <th>Permanent Address</th>
                                <th>Company</th>
                                <th>NID</th>
                                <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                                    <i class="feather icon-settings"></i>

                            </tr>
                            </thead>

                            <tbody>
                            @php $i=0; @endphp

                            @foreach( $users as $user )
                                @php $i++ @endphp

                                <tr>
                                    <td>{{$i}}</td>
                                    <td> {{$user->UserProfile['fname'].' '.$user->UserProfile['lname']}}</td>
                                    <td> {{ $user->email }}</td>
                                    <td> {{ $user->UserProfile['mobile'] }}</td>
                                    <td> {{ $user->UserProfile['fathername'] }}</td>
                                    <td> {{ $user->UserProfile['mothername'] }}</td>
                                    <td> {{ $user->UserProfile['joindate']}}</td>
                                    <td> {{ $user->UserProfile['p_address'] }}</td>
                                    <td> {{ $user->UserProfile['address']}} </td>



                                    <?php $company = \App\Company::find($user->UserProfile['company_id']);?>
                                    <td> {{ $company['name'] }} </td>

                                    <td> {{ $user->UserProfile['nid'] }} </td>
                                    <td>
                                        <div class="btn-group card-option">
                                            <a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                            <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">

                                                <li class="dropdown-item">
                                                    <a href="{{route('userprofile_show',$user->id)}}">
                                                        <i class="feather icon-eye"></i>
                                                        Show</a>
                                                </li>


                                                <li class="dropdown-item">
                                                    <a href="{{route('User_delete',$user->id)}}">
                                                        <i class="feather icon-trash-2"></i>
                                                        Remove</a>
                                                </li>

                                                <li class="dropdown-item">
                                                    <a href="{{route('userprofileEdit',$user->id)}}">
                                                        <i class="feather icon-edit"></i>
                                                        Edit</a>
                                                </li>

                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection