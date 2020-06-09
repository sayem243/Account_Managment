@extends('admin.index-pdf')

@section('template')
    {{--<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>--}}

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="img-container"> <img src="{{asset('assets/images/PUL.png')}}" width="100px" > </div><style>
                            .img-container{
                                text-align: center;
                            }
                        </style>
                        <h1 align="center"> Payment Details </h1>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <h4 align="center">Amendment Details</h4>
                        </div>

                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Projects</th>
                                <th>Amendment (BDT)</th>
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

                            <tr><b> Total Paid : {{$payment->total_amendment_amount}} BDT  </b> </tr>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection