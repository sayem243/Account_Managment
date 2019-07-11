@extends('layout.Master')

@section('content')

<h2>Edit Page</h2>


{{--<form method="post" action="/register">--}}

<form class="form-horizontal" action="{{ route('update',$user->id)}}" method="post">

    {{ csrf_field() }}



    <div class="form-group">
    <label class="control-label col-sm-2" for="Name">Name:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{$user->name}}">
    </div>
</div>


<div class="form-group">
    <label class="control-label col-sm-2" for="regestration_id">Email:</label>
    <div class="col-sm-10">
        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{$user->email}}">
    </div>
</div>



<div class="form-group">
    <label class="control-label col-sm-2" for="mobile">Mobile:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" value="{{$user->mobile}}">
    </div>
</div>


<div class="form-group">
    <label class="control-label col-sm-2" for="text">Company Name:</label>
    <div class="col-sm-10">

        <select name="company_id">
            <option value="">Select Company</option>
            @foreach($companies as $company)
                <option value="{{$company->id}}" {{$company->id==$user->company_id?'selected="selected"':''}}>{{$company->name}}</option>
            @endforeach
        </select>

    </div>
</div>




<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger">Submit  </button>
    </div>
</div>














</form>

    @endsection