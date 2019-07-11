@extends('layout.Master')

@section('content')
    <form class="table-responsive" action="{{ route('setting_store')}}" method="post">

        {{csrf_field()}}

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Employee Typee </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="empl_type" placeholder="Employee Typee ">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Designstion</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="des_id" placeholder="Designation">
            </div>
        </div>



        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-outline-success">Submit  </button>
            </div>
        </div>

    </form>



@endsection