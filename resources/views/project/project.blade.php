@extends('layout')
@section('title','Project List')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Manage Project </h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                                <a style="-webkit-transform: scale(0.9);" href="{{route('project_create')}}" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
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
                        <table class= "table table-bordered">

                            <thead class="thead-dark">
                            <tr>
                                <th>Serial</th>
                                <th>Project Name</th>
                                <th>Companies</th>
                                <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                                    <i class="feather icon-settings"></i>

                                </th>
                            </tr>
                            </thead>

                            @foreach($companies as $company)

                                <tr>
                                    <td align="center" colspan="5"><h5>{{$company->name}}</h5></td>
                                </tr>

                                @php $i=0; @endphp
                                @if (array_key_exists($company->id, $projects))

                                @foreach($projects[$company->id] as $key=>$project)
                                    @php $i++ @endphp
                                    <tr>
                                        <td>{{$i}}</td>

                                        <td>{{$project->projectName}} </td>
                                        <td>{{ $project->companyName}}</td>
                                        <td>
                                            <div class="btn-group card-option">
                                                <a href="javascript:"  class="btn btn-notify btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
                                                    <li class="dropdown-item">
                                                        <a href="{{route('project_edit',$project->id)}}">
                                                            <i class="feather icon-edit"></i>
                                                            Edit</a>
                                                    </li>
                                                    @if(auth()->user()->hasRole('superadmin') && $project->deletedAt==null)
                                                    <li class="dropdown-item">
                                                        <a href="{{route('project_delete',$project->id)}}">
                                                            <i class="feather icon-trash-2"></i>
                                                            Remove</a>
                                                    </li>
                                                    @endif

                                                    @if(auth()->user()->hasRole('superadmin') && $project->deletedAt!=null)
                                                        <li class="dropdown-item">
                                                            <a href="{{route('project_restore',$project->id)}}">
                                                                <i class="fa fa-undo" aria-hidden="true"></i>
                                                                Restore</a>
                                                        </li>
                                                    @endif
                                                </ul>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                                    @else

                                    <tr>
                                        <td colspan="5">No project found</td>
                                    </tr>

                                @endif

                            @endforeach
                        </table>
                    </div>

                </div>
                <!-- Input group -->

            </div>
        </div>
    </div>
@endsection


