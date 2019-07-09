@extends('layout.Master')

@section('content')

<h2>Register</h2>


{{--<form method="post" action="/register">--}}

<form class="form-horizontal" action="{{ route('account_store')}}" method="post">

    {{ csrf_field() }}

{{--error showing --}}


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif





    <div class="form-group">
    <label class="control-label col-sm-2" for="Name">Name:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="name" id="name" placeholder="Name">
    </div>
</div>


<div class="form-group">
    <label class="control-label col-sm-2" for="regestration_id">Email:</label>
    <div class="col-sm-10">
        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
    </div>
</div>



<div class="form-group">
    <label class="control-label col-sm-2" for="mobile">Mobile:</label>
    <div class="col-sm-10">
        <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number">
    </div>
</div>


<div class="form-group">
    <label class="control-label col-sm-2" for="text">Company Name:</label>
    <div class="col-sm-10">
        <select name="company_id">
            <option value="">Select Company</option>
            @foreach($companies as $company)
                <option value="{{$company->id}}">{{$company->name}}</option>
                @endforeach
        </select>

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