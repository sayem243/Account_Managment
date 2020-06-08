@extends('admin.index')
@section('title','Project Update')
@section('template')

    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">
                <h5>Project Update</h5>
                <div class="card-header-right">
                    <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                        <a href="{{route('project')}}" class="btn btn-sm  btn-info"><i class="fas fa-angle-double-left"></i> Back</a>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">

                <form class="form-horizontal" action="{{ route('project_update',$project->id)}}" method="post">

                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="p_name">Name</label>
                                <input type="text" class="form-control" id="p_name" name="p_name" aria-describedby="name" placeholder="Enter project name" value="{{$project->p_name}}">
                            </div>
                            <div class="form-group">
                                <label for="company_id">Company</label>
                                <select class="form-control" name="company_id">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}" {{$company->id==$project->company_id?'selected="selected"':''}}> {{$company->name}} </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea type="text" class="form-control" rows="8" id="address" name="address" aria-describedby="name" placeholder="Enter project address">{{$project->address}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-12" align="right">
                            <button type="submit" class="btn btn-primary">Save </button>
                        </div>
                    </div>


                </form>

            </div>
        </div>

    </div>
@endsection