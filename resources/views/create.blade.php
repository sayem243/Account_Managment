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
        <label class="control-label col-sm-2" for="mobile">NID</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" name="nid" id="nid" placeholder="NID Number">
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-sm-2" for="mobile">Joining Date</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="date" id="date" placeholder="Joining Date">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="Name">Address:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="address" id="addres" placeholder="Address">
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
        <label class="control-label col-sm-2" for="project_id">Projects</label>
        <div class="col-sm-10">

            <select name="project_id">
                <option value="">Select User</option>
                @foreach($projects as $project)
                    <option value="{{$project->id}}"> {{$project->p_name}} </option>
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