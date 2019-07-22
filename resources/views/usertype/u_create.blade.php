@extends('layout.Master')

@section('content')
    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">

<h2 align="center">User Sub Type Form</h2>
<form class="form-horizontal" action="{{ route('usertype_store')}}" method="post">

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
    <label class="control-label col-sm-2" for="u_title">Tittle :</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="u_title" id="u_title" placeholder="User Tittle">
    </div>
</div>






    {{--<div class="form-group">--}}
    {{--<label class="control-label col-sm-2" for="regestration_id">Email:</label>--}}
    {{--<div class="col-sm-10">--}}
        {{--<input type="email" class="form-control" name="email" id="email" placeholder="Email">--}}
    {{--</div>--}}
{{--</div>--}}



{{--<div class="form-group">--}}
    {{--<label class="control-label col-sm-2" for="mobile">Mobile:</label>--}}
    {{--<div class="col-sm-10">--}}
        {{--<input type="number" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number">--}}
    {{--</div>--}}
{{--</div>--}}


{{--<div class="form-group">--}}
    {{--<label class="control-label col-sm-2" for="text">Company Name:</label>--}}
    {{--<div class="col-sm-10">--}}
        {{--<select name="company_id">--}}
            {{--<option value="">Select Company</option>--}}
            {{--@foreach($companies as $company)--}}
                {{--<option value="{{$company->id}}">{{$company->name}}</option>--}}
                {{--@endforeach--}}
        {{--</select>--}}

    {{--</div>--}}
{{--</div>--}}




<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger">Submit  </button>
    </div>
</div>

</form>

            </div>
        </div>
    </div>
@endsection