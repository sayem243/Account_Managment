{{--@extends('layout.Master')--}}

{{--@section('content')--}}

@extends('admin.index')

@section('template')

    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">



    <form class="form-horizontal" action="{{ route('payment_store')}}" method="post">

        {{ csrf_field() }}



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
            <label class="control-label col-sm-2" for="demand_amount">Demand Amount:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="demand_amount" id="demand_amount" placeholder="Demand">
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-sm-2" for="payment_amount">Payment Amount:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="payment_amount" id="payment_amount" placeholder="Payment">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="company_id">Company:</label>
            <div class="col-sm-10">



                <select class="form-control" name="company_id">
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"> {{$company->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-sm-2" for="user_id">Employee:</label>
            <div class="col-sm-10">

                <select class="form-control" name="user_id">
                    <option value="">Select Employee</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}"> {{$user->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>






        <div class="form-group">
            <label class="control-label col-sm-2" for="project_id">Projects</label>
            <div class="col-sm-10">

                <select class="form-control" name="project_id">
                    <option value="">Projects</option>
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

            </div>
        </div>
    </div>


{{--@endsection--}}

@endsection