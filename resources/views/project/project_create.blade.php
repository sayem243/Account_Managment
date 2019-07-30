@extends('admin.index')
@section('template')


<div class="col-sm-12">
    <div class="card" id="references">
        <div class="card-header">Project </div>



    <form class="form-horizontal" action="{{ route('project_store')}}" method="post">

        {{ csrf_field() }}

        <div class="row">

            <div class="col-md-8">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



    {{--<div class="form-group">--}}
        {{--<label class="control-label col-sm-2" for="Name">Project Name:</label>--}}
        {{--<div class="col-sm-10">--}}
            {{--<input type="text" class="form-control" name="p_name" id="p_name" placeholder="Name">--}}
        {{--</div>--}}
    {{--</div>--}}


            <div class="form-group">
                <label class="control-label col-sm-4" for="Name">Project Name</label>
                <input type="text" class="form-control" name="p_name" id="p_name"placeholder=" Name">
            </div>



            <div class="form-group">
                <label class="control-label col-sm-4" for="regestration_id">Project Name</label>
                <input type="text" class="form-control" name="p_title" id="p_title"placeholder=" project Tittle">
            </div>




            {{--<div class="form-group">--}}
        {{--<label class="control-label col-sm-2" for="regestration_id">Project Tittle:</label>--}}
        {{--<div class="col-sm-10">--}}
            {{--<input type="text" class="form-control" name="p_title" id="p_title" placeholder="project Tittle">--}}
        {{--</div>--}}
    {{--</div>--}}

        <div class="form-group">
            <label class="control-label col-sm-4">Company</label>

        <select class="form-control" name="company_id">
            <option value="">Select Company</option>
            @foreach($companies as $company)
                <option value="{{$company->id}}"> {{$company->name}} </option>
            @endforeach
        </select>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Submit  </button>
            </div>
        </div>




            </div>
        </div>

    </form>





    </div>
</div>



@endsection
