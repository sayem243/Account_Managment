@extends('layout.Master')

@section('content')


    <form class="form-horizontal" action="{{ route('payment_store')}}" method="post">

        {{ csrf_field() }}

        <div class="form-group">
            <label class="control-label col-sm-2" for="demand_amount">Demand Amount:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="demand_amount" id="demand_amount" placeholder="Name">
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-sm-2" for="payment_amount">Payment Amount:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="payment_amount" id="payment_amount" placeholder="project Tittle">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="company_id">Company:</label>
            <div class="col-sm-10">

                <select name="company_id">
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"> {{$company->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="user_id">User:</label>
            <div class="col-sm-10">

                <select name="user_id">
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}"> {{$user->name}} </option>
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