@extends('admin.index-pdf')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        {{--<h5>Voucher Details</h5>--}}
                        <div class="img-container"> <img src="{{asset('assets/images/PUL.png')}}" width="100px" > </div><style>
                            .img-container{
                                text-align: center;
                            }
                        </style>

                    </div>

                    <div class="card-body">
                        <div class="row">
                            <table cellpadding="4" width="100%" class="">
                                <tr>
                                    <td>
                                        <label for="">Employe Name: </label>
                                        {{$details->user->UserProfile['fname'].' '.$details->user->UserProfile['lname']}}
                                    </td>

                                    <td>
                                        <label for="exampleInputEmail1">Payment Date: </label>
                                        {{date('d-m-Y',strtotime($details->created_at))}}
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <label for="">Company: </label>
                                        {{$details->user->userProfile->company['name']}}
                                    </td>
                                    <td>
                                        <label for="">Mobile Number: </label>
                                        {{$details->user->userProfile['mobile'] }}
                                    </td>
                                </tr>
                                {{--<tr>--}}
                                    {{--<td colspan="2">--}}
                                        {{--<label for="">NID: </label>--}}
                                        {{--{{$details->user->userProfile['nid'] }}--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td colspan="2">
                                        <label for=""><b>Remarks :</b></label>
                                        {{$details->comments}}
                                    </td>
                                </tr>
                            </table>
                        </div>


                        <div class="col-md-12">
                            <h4 align="center"><em>Voucher Details </em>  </h4>
                        </div>

                        <table class= "table table-bordered" id="voucher">
                            <thead class="thead-dark">
                            <tr>
                                <th>Serial</th>
                                <th>Payment ID</th>
                                <th>Project</th>
                                <th>Received</th>
                                <th>Date</th>


                            </tr>
                            </thead>

                            @php $i=0; @endphp
                            @foreach($details->vocher_details as $detail)
                                @php $i++ @endphp

                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$detail->payment->payment_id}}</td>
                                    <td>{{$detail->project['p_name']}}</td>

                                    <td>{{$detail->amount}}</td>
                                    <td>{{date('d-m-y',strtotime($detail->created_at))}}</td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection