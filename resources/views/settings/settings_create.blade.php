{{--@extends('layout.Master')--}}

{{--@section('content')--}}
    {{----}}

@extends('layout')

@section('template')

    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">


    <form class="form-horizontal" action="{{ route('setting_store')}}" method="post">

        {{csrf_field()}}

        <div class="form-group row">
            <label for="settingType" class="col-sm-2 col-form-label">Option</label>
            <div class="col-sm-6">
              <select class="form-control" name="empl_type" id="empl_type">

                  <option value="designation">Designation</option>
                  <option value="Supplier">Supplier</option>
                  <option value="Constractor">Constractor </option>
              </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="des_id" id="des_id" placeholder="Enter setting name">
            </div>
        </div>



        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-12" align="right">
                <button type="submit" class="btn btn-primary">Submit  </button>
            </div>
        </div>

    </form>


</div>
        </div>
    </div>



@endsection