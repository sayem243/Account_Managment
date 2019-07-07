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
        <input type="text" class="form-control" name="c_name" id="c_name" placeholder="company Name" value="{{$user->c_name}}">
    </div>
</div>




<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger">Submit  </button>
    </div>
</div>















    {{--<div class="form-group">--}}
        {{--<label for="name">Name:</label>--}}
        {{--<input type="text" class="form-control" id="name" name="name">--}}
    {{--</div>--}}

    {{--<div class="form-group">--}}
        {{--<label for="email">Email:</label>--}}
        {{--<input type="email" class="form-control" id="email" name="email">--}}
    {{--</div>--}}

    {{--<div class="form-group">--}}
        {{--<label for="email">Mobile:</label>--}}
        {{--<input type="email" class="form-control" id="mobile" name="mobile">--}}
    {{--</div>--}}



    {{--<div class="form-group">--}}
        {{--<label for="name">Company  Name:</label>--}}
        {{--<input type="text" class="form-control" id="C_name" name="name">--}}
    {{--</div>--}}


    {{--<div class="form-group">--}}
        {{--<button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button>--}}
    {{--</div>--}}
</form>

    @endsection