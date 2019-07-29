@extends('admin.index')

@section('template')


    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">

    <div class="text-center"><h2>company Details </h2>

        <div class="table-responsive-md">
            <table class= "table table-responsive table-hover">
                <tr>
                    <th>SL</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Number</th>
                    <th>Address</th>
                    <th>Logo</th>
                    <th>Action</th>
                </tr>
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

                            <div class="btn-group-vertical">
                                <a href="{{route('comp_edit',$company->id)}}" button type="button" class="btn btn-primary" >Edit </a>
                        <a href="{{route('com_delete', $company->id)}}" button type="button" class="btn btn-primary">Delete</a>

                            </div>





                        {{----}}
                        {{--<td> <a href="{{route('edit',$company->id)}}" class="btn btn-success">Edit </a></td>--}}
                        {{--<td> <a href="{{route('delete',$company>id)}}" class="btn btn-danger">Delete </a></td>--}}

                    </tr>

                @endforeach
            </table>
        </div>

    </div>
    </div>
        </div>
    </div>


@endsection