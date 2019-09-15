@extends('admin.index-pdf')

@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h1 align="center"> Payment Details </h1>
                    </div>

                    {{--Advance Payment Information--}}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Payment ID: </label>
                                    {{$payment->payment_id }}
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Payment Date: </label>
                                    {{date('d-m-Y',strtotime($payment->created_at))}}
                                </div>



                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">User Name: </label>
                                    {{--{{$payment->user['name'] }}--}}
                                    {{$payment->user->UserProfile['fname'].' '.$payment->user->UserProfile['lname']}}

                                </div>

                                <div class="form-group">
                                    <label for="">Mobile Number: </label>
                                    {{$payment->user->userProfile['mobile'] }}
                                </div>

                                <div class="form-group">
                                    <label for="">NID: </label>
                                    {{$payment->user->userProfile['nid'] }}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <h4 align="center">Advance Payment Details</h4>
                        </div>

                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Projects</th>
                                <th>Demand Amount(BDT) </th>
                                <th>Paid Amount</th>
                                <th>Date</th>

                            </tr>
                            </thead>


                            <tbody>
                            @php
                                $i=0;

                            @endphp

                            @foreach($payment->Payment_details as $detail )
                                @php
                                    $i++ ;
                                @endphp

                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$detail->project['p_name']}}</td>
                                    <td>{{$detail->demand_amount}}</td>
                                    <td>{{$detail->paid_amount}}</td>
                                    <td> {{date('d-m-Y',strtotime($detail->created_at))}}</td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                        <div class="col-md-12">
                            <h4 align="center">Amendment Details</h4>
                        </div>

                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Projects</th>
                                <th>Amendment Amount</th>
                                <th>Date</th>

                            </tr>
                            </thead>


                            <tbody>
                            @php
                                $i=0;

                            @endphp

                            @foreach($payment->ammendments as $detail )
                                @php
                                    $i++ ;
                                @endphp

                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$detail->project['p_name']}}</td>
                                    <td>{{$detail->amendment_amount}}</td>
                                    <td> {{date('d-m-Y',strtotime($detail->created_at))}}</td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>




                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection