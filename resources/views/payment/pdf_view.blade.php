@extends('admin.index-pdf')
@section('title','Hand Slip')
@section('template')
    {{--<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>--}}

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td style="vertical-align: top">
                                        <h5 style="margin-bottom: 8px">Project: {{$payment->project['p_name']}}</h5>
                                        <h5>Company: {{$payment->company['name']}}</h5>
                                    </td>
                                    <td style="vertical-align: top">
                                        <h4>SH ID: {{$payment->payment_id}}</h4>
                                    </td>
                                    <td style="vertical-align: top" align="right">
                                        <h4>Date: {{ date('d-m-Y', strtotime($payment->created_at))}}</h4>
                                        <h5 style="color: red">Total Amount: {{$payment->total_paid_amount}}</h5>
                                    </td>
                                </tr>
                                </thead>
                            </table>

                        </div>
                        <hr style="margin-top: 1px; margin-bottom: 10px">
                        <div class="row">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td width="40%" style="vertical-align: top">
                                        <h5 style="margin-bottom: 8px">Name: {{$payment->user['name']}}</h5>
                                        <p>Created By: {{$payment->userCreatedBy['name']}}</p>
                                        <p>Verified By: {{$payment->verifiedBy?$payment->verifiedBy['name']:''}}</p>
                                        <p>Approved By: {{$payment->approvedBy?$payment->approvedBy['name']:''}}</p>
                                        <p>Disbursed By: {{$payment->disbursedBy?$payment->disbursedBy['name']:''}}</p>

                                        <div class="signature_area" style="border: 1px solid #000000; height: 60px; width: 250px;text-align: center">
                                            Signature

                                        </div>
                                    </td>
                                    <td width="60%" style="vertical-align: top">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="padding: 5px" align="left" width="75%">Item</th>
                                                <th width="25%" style="text-align: right;padding-right: 10px">Amount </th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($payment->Payment_details as $paymentDetail)
                                                <tr>
                                                    <td style="padding: 2px 5px">{{$paymentDetail->item_name}}</td>
                                                    <td style="text-align: right;padding-right: 10px">{{$paymentDetail->paid_amount}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr style="font-weight: bold; font-size: 18px; color: red">
                                                <td style="text-align: right;padding-right: 10px">Total</td>
                                                <td style="text-align: right;padding-right: 10px">{{$payment->total_paid_amount}}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                                </thead>
                            </table>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @php use App\CustomClass\NumberToWordConverter;
                               $amount = NumberToWordConverter::convert($payment->total_paid_amount);
                                @endphp
                                <p style="color: red;"><strong style="font-weight: bold">Write in words: </strong>{{$amount}}</p>
                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div>


@endsection