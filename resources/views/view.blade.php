@extends('layout.Master')

@section('content')




    {{--<div class="form-group">--}}
    {{--<label class="control-label col-sm-2" for="Name">Name:</label>--}}
    {{--<div class="col-sm-10">--}}
        {{--{{$company->name}}--}}
        {{----}}
    {{--</div>--}}
    {{--</div>--}}





<div class="text-center"><h2>company Details </h2>

    <div class="container-fluid">
        <table class= "table table-responsive table-hover">
            <tr>
                <th>Serial</th>
                <th>ID</th>
                <th>Company  Name</th>
                <th>Company email</th>
                <th>Company  Mobile Number</th>
                <th>Company Address</th>
                <th>company Logo</th>
                <th>Action</th>
            </tr>


            @php $i=0; @endphp
            @php $i++ @endphp


            <tr>

                <td>{{$i}}</td>
                <td>{{$company->id}}</td>

                <td>{{$company->name}}</td>
                <td>{{$company->c_email}}</td>
                <td>{{$company->c_mobile}}</td>
                <td>{{$company->c_address}}</td>
                <td><img src="{{Storage::url($company->c_img) }}" alt="404" width="100px" ></td>

            </tr>



                {{--<tr>--}}
                    {{--<td>{{$i}}</td>--}}
                    {{--<td>{{$company->id}} </td>--}}
                    {{--<td>{{$company->name}}</td>--}}
                    {{--<td>{{$company->c_email}}</td>--}}
                    {{--<td>{{$company->c_mobile}}</td>--}}
                    {{--<td>{{$company->c_address}}</td>--}}


                    {{--<td><img src="{{Storage::url($company->c_img) }}" alt="404" width="100px" ></td>--}}


                {{--</tr>--}}



        </table>
    </div>

</div>







@endsection