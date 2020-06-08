@extends('admin.index')
@section('template')
{{--@section('content')--}}

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Role Management</h5>
                    <div class="card-header-right">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                            @can('role-create')
                                <a class="btn btn-sm  btn-info" href="{{ route('roles.create') }}"> New Role</a>
                            @endcan
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
            <th>No</th>
            <th>Name</th>
            <th>Action</th>
            <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                <i class="feather icon-settings"></i>

            </th>
        </tr>
    </thead>
        <tbody>
        @foreach ($roles as $key => $role)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $role->name }}</td>
                <td>

                    {{--@can('role-delete')--}}
                        {{--{!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}--}}
                        {{--{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}--}}
                        {{--{!! Form::close() !!}--}}
                    {{--@endcan--}}

                </td>
                <td>
                    <div class="btn-group card-option">
                        <a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                        <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
                            @can('role-edit')
                            <li class="dropdown-item">
                                    <a href="{{route('roles.edit',$role->id)}}">
                                        <i class="feather icon-edit"></i>
                                        Edit</a>
                                </li>
                            @endcan
                            <li class="dropdown-item">
                                <a href="{{route('roles.show',$role->id)}}">
                                    <i class="feather icon-eye"></i>
                                    Show</a>
                            </li>

                            <li class="dropdown-item">
                                @can('role-delete')
                                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id]]) !!}
                                <i class="feather icon-trash-2"> {!! Form::submit('Delete') !!}     </i>
                                {!! Form::close() !!}
                                @endcan

                            </li>


                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

</div>
                <ul class="pagination justify-content-end">
                    {{$roles->render('vendor.pagination.bootstrap-4')}}
                </ul>

                <p class="text-center text-primary"><small>©2019 Right Brain Solution Limited.All Rights Reserved</small></p>
        </div>

    </div>
</div>
</div>


    {{--{!! $roles->render() !!}--}}



@endsection