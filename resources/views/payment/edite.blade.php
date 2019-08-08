@extends('admin.index')

@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Add Payment</h5>
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

                    <div class="card-block">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('payment_update',$payment->id)}}" method="post" enctype="multipart/form-data">

                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-6">


                                        <div class="form-group">
                                            <label class="col-form-label" for="demand_amount">Demand Amount:<span class="required">*</span></label>
                                            <div class="col-form-label">
                                                <input type="text" class="form-control" name="demand_amount" id="demand_amount" aria-describedby="validationTooltipUsernamePrepend"  required="" value="{{$payment->d_amount}}">
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-form-label" for="payment_amount">Payment Amount:</label>
                                            <div class="col-form-label">
                                                <input type="text" class="form-control" name="payment_amount" id="payment_amount" aria-describedby="validationTooltipUsernamePrepend" required="" value="{{$payment->due}}" >
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-form-label" for="company_id">Company:</label>
                                            <div class="col-form-label">

                                                <select class="form-control" name="company_id">
                                                    <option value="">Select Company</option>
                                                    @foreach($companies as $company)
                                                        <option value="{{$company->id}}"> {{$company->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-form-label" for="user_id">Employee:</label>
                                            <div class="col-form-label">

                                                <select class="form-control" name="user_id">
                                                    <option value="">Select Employee</option>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}"> {{$user->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>



                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-form-label" for="project_id">Projects</label>
                                            <div class="col-form-label" >
                                                <select class="form-control"  name="project_id" multiple id="multiple">
                                                    <option value=""></option>
                                                    @foreach($projects as $project)
                                                        <option value="{{$project->id}}"> {{$project->p_name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-form-label" for="comments">Comments </label>
                                            <div class="col-form-label">
                <textarea type="text" class="form-control" rows="8" name="comments" id="comments" aria-describedby="name">
                </textarea>

                                            </div>
                                        </div>




                                    </div>

                                </div>


                                <div class="separator"></div>

                                <div class="line aligncenter">

                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label"></div>
                                        <div class="col-sm-6 col-form-label">
                                            <button type="submit" class="btn purple-bg white-font" data-original-title="" title=""> <i class="feather icon-save"></i> Confirm</button>
                                            <button type="reset" class="btn btn btn-outline-danger" data-original-title="" title=""> <i class="feather icon-refresh-ccw"></i> Cancel</button>
                                        </div>
                                    </div>

                                </div>

                            </form>



                        </div>
                    </div>

                </div>
            </div>



        </div>


    </div>





@endsection