@extends('admin.index')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Voucher Edit </h5>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="{{route('voucher_update',$vochers->id)}}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Payment ID</label>
                                        <select class="form-control" name="payment_id" >
                                            <option value="">Select Payment ID</option>
                                            @foreach($payments as $payment)
                                                <option value="{{$payment->id}}"> {{$payment->id}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Enter the Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" aria-describedby="name" value="amount" required >
                                    </div>


                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Project ID</label>
                                        <select class="form-control" name="project_id" multiple >
                                            <option value="">Select Project</option>
                                            @foreach($projects as $project)
                                                <option value="{{$project->id}}"> {{$project->p_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="amount">Attach File</label>
                                        <input type="file" class="form-control" id="file" name="file" aria-describedby="name">
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
            </div>
        </div>
    </div>


@endsection