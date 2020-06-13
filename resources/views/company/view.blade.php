@extends('layout')
@section('title','Details Company')
@section('content')


    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">

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




        </table>
    </div>

</div>


</div>
        </div>
    </div>




@endsection