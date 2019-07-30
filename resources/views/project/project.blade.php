{{--@extends('layout.Master')--}}
@extends('admin.index')

{{--@section('content')--}}

    @section('template')
        <div class="col-sm-12">
            <div class="card" id="references">
                <div class="card-header">



    <div class="text-center"><h2> Project Details </h2>

        <div class="table-responsive-lg">
            <table class= "table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Serial</th>

                    <th>Project   Name</th>
                    <th>Project Tittle </th>
                    <th>Company Involved</th>

                    <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                        <i class="feather icon-settings"></i>

                    </th>


                </tr>
                </thead>
                @php $i=0; @endphp


                @foreach($projects as $project)

                    @php $i++ @endphp

                    <tr>
                        <td>{{$i}}</td>

                        <td>{{$project->p_name}} </td>
                        <td>{{$project->p_title}}</td>

                        <td>{{$project->company['name']}}</td>
                        <td>


                            {{--<div class="btn-group-vertical">--}}
                                {{--<a href="{{route('project_edit',$project->id)}}"  button type="button" class="btn btn-primary a-btn-slide-text">  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>--}}
                                    {{--<span><strong>Edit</strong></span> </a>--}}
                                {{--<a href="{{route('project_delete', $project->id)}}" button type="button" class="btn btn-primary a-btn-slide-text"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>--}}
                                    {{--<span><strong>Delete</strong></span> </a>--}}



                            {{--</div>--}}
                            {{----}}

                            <div class="btn-group card-option">
                                <button type="button" class="btn btn-notify" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
                                    <li class="dropdown-item">
                                        <a href="{{route('project_edit',$project->id)}}">
                                            <i class="feather icon-edit"></i>
                                            Edit</a>
                                    </li>

                                    <li class="dropdown-item">
                                        <a href="{{route('project_delete',$project->id)}}">
                                            <i class="feather icon-trash-2"></i>
                                            Remove</a>
                                    </li>


                                </ul>


                            </div>






                        </td>

                    </tr>




                @endforeach

            </table>
        </div>

    </div>

                </div>
            </div>
        </div>


    @endsection

        {{--@endsection--}}
