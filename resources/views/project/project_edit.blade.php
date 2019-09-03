@extends('admin.index')
@section('template')

    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">

                <form class="form-horizontal" action="{{ route('project_update',$project->id)}}" method="post">

                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="Name">Project Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="p_name" id="p_name" placeholder="Name" value="{{$project->p_name}}">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-sm-2" for="regestration_id">Address:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="address" id="address" placeholder="" value="{{$project->p_title}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="regestration_id">Companies</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="company_id" multiple="multiple">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}"> {{$company->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-12" align="right">
                            <button type="submit" class="btn btn-primary">Save  </button>
                        </div>
                    </div>


                </form>

            </div>
        </div>

    </div>
@endsection