@extends('admin.index')
@section('template')
    <div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Manage Project </h5>
                    <div class="card-header-right">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                            <a href="{{route('project')}}" class="btn btn-sm  btn-info"><i class="fas fa-angle-double-left"></i>Back</a>
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
                    <form class="form-horizontal" action="{{ route('project_store')}}" method="post">

                        {{ csrf_field() }}
                    <div class="row">

                        <div class="col-md-6">


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" id="p_name" name="p_name" aria-describedby="name" placeholder="Enter project name">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Companies</label>
                                    <select class="form-control" name="company_id" multiple="multiple">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}"> {{$company->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea type="text" class="form-control" rows="8" id="address" name="address" aria-describedby="name" placeholder="Enter project address"></textarea>
                            </div>
                        </div>


                    </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-12" align="right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <!-- Input group -->

        </div>
    </div>
    </div>
@endsection
