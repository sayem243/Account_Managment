@extends('admin.index')

@section('template')


    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">

    <div class="text-center"><h2>Company Details </h2>

        <div class="table-responsive-lg">
            <table class= "table table-responsive table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>SL</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Number</th>
                    <th>Address</th>
                    <th>Logo</th>
                    <th
                        scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                        <i class="feather icon-settings"></i>

                    </th>
                </tr>
                </thead>
                @php $i=0; @endphp


                @foreach($companys as $company)

                    @php $i++ @endphp

                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$company->id}} </td>
                        <td>{{$company->name}}</td>
                        <td>{{$company->c_email}}</td>
                        <td>{{$company->c_mobile}}</td>
                        <td>{{$company->c_address}}</td>

                        <td><img src="{{Storage::url($company->c_img) }}" alt="404" width="100px" ></td>
                        <td>

                            {{--<div class="btn-group-vertical">--}}
                                {{--<a href="{{route('comp_edit',$company->id)}}" button type="button" class="btn btn-primary" >Edit </a>--}}
                        {{--<a href="{{route('com_delete', $company->id)}}" button type="button" class="btn btn-primary">Delete</a>--}}

                            {{--</div>--}}


                            <div class="btn-group card-option">
                                <button type="button" class="btn btn-notify" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
                                    <li class="dropdown-item">
                                        <a href="{{route('comp_edit',$company->id)}}">
                                            <i class="feather icon-edit"></i>
                                            Edit</a>
                                    </li>

                                    <li class="dropdown-item">
                                        <a href="{{route('com_delete',$company->id)}}">
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