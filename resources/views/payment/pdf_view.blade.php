@extends('admin.index-pdf')

@section('template')
    {{--<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>--}}

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
{{--                        <div class="img-container"> <img src="{{asset('assets/images/PUL.png')}}" width="100px" > </div>--}}
{{--                        <style>--}}
{{--                            .img-container{--}}
{{--                                text-align: center;--}}
{{--                            }--}}
{{--                        </style>--}}
                        <h1 align="center"> Payment Details </h1>
                    </div>

                    {{--Advance Payment Information--}}

                    <div class="card-body">
                        <div class="row">
                         <table cellpadding="3" width="100%" class="">
                             <tr>
                                 <td>
                                     <label for="">Employe Name: </label>
                                     {{$payment->user->UserProfile['fname'].' '.$payment->user->UserProfile['lname']}}
                                 </td>
                                 <td>
                                     <label for="exampleInputEmail1">Payment ID: </label>
                                     {{$payment->payment_id }}
                                 </td>
                             </tr>
                             <tr>
                                 <td> <label for="exampleInputEmail1">Payment Date: </label>
                                     {{date('d-m-Y',strtotime($payment->created_at))}}
                                 </td>
                                 <td>
                                     <label for="">Mobile Number: </label>
                                     {{$payment->user->userProfile['mobile'] }}
                                 </td>
                             </tr>

                             <tr>
                                 <td>
                                     @if($payment->status==3)
                                         <label for="">Approved By: </label>
                                         {{$payment->approvedBy['name']}}
                                     @endif


                                 </td>
                                 <td>

                                     <label for="">Verified By:</label>
                                     {{$payment->verifiedBy['name']}}

                                 </td>
                             </tr>
                             <tr>

                                 <td>
                                     <label for="">Company: </label>
                                     {{$payment->user->userProfile->company['name']}}


                                 </td>
                             </tr>

                             <tr>
                                 <td>
                                     <label for=""><b>Remarks :</b></label>
                                     <b>{{$payment->comments}}</b>
                                 </td>
                             </tr>

                         </table>
                        </div>



                        <div class="col-md-12">
                            <h4 align="center">Advance Payment Details</h4>
                        </div>

                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Projects</th>
                                <th>Demand (BDT) </th>
                                <th>Paid (BDT)</th>
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


                            <tr><b> Total Paid : {{$payment->total_paid_amount}} BDT  </b> </tr>
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