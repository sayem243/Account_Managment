{{--@extends('layout.Master')--}}

{{--@section('content')--}}
    {{----}}

@extends('admin.index')

@section('template')

    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">


    <form class="form-horizontal" action="{{ route('setting_store')}}" method="post">

        {{csrf_field()}}

        <div class="form-group row">
            <label for="settingType" class="col-sm-2 col-form-label">Option</label>
            <div class="col-sm-10">
              <select class="form-control" name="settingType" id="settingType">
                  <option value="employee">Employee Type</option>
                  <option value="designation">Designation</option>
                  <option value="designation">Supplier</option>
                  <option value="designation">Constractor </option>
              </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter setting name">
            </div>
        </div>



        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-outline-success">Submit  </button>
            </div>
        </div>

    </form>


</div>
        </div>
    </div>



@endsection