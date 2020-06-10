@extends('admin.index')
@section('title','Confirm Payment')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
            <div class="card-header">
                <h5> Payment Details </h5>

                </div>

                    <form class="form-horizontal" action="{{ route('payment_store_confirm')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                    {{--Advance Payment Information--}}
                    @foreach($payments as $payment)

                        <input type="hidden" value="{{$payment->id}}" name="payment_id[]">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Payment ID: {{$payment->payment_id}}</h4>
{{--                                --}}
                            </div>
                            <div class="col-md-6" style="text-align: right">
                                <h4>Date: {{ date('d-m-Y', strtotime($payment->created_at))}}</h4>
                                <h6>Total Amount: {{$payment->total_paid_amount}}</h6>
                            </div>
                        </div>
                        <hr style="margin-top: 1px; margin-bottom: 10px">
                        <div class="row">
                            <div class="col-md-3">
                                <p>Name: {{$payment->user['name']}}</p>
                                {{--<p>Total Amount: {{$payment->total_paid_amount}}</p>--}}
                                <p>Created By: {{$payment->userCreatedBy['name']}}</p>
                                <p>Verified By: {{$payment->verifiedBy?$payment->verifiedBy['name']:''}}</p>
                                <p>Approved By: {{$payment->approvedBy?$payment->approvedBy['name']:''}}</p>
                                <p>Disbursed By: {{$payment->disbursedBy?$payment->disbursedBy['name']:''}}</p>

                                <div class="signature_area" style="border: 1px solid #000000; height: 60px; width: 250px;text-align: center">
                                    Signature

                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Project: {{$payment->project['p_name']}}</p>
                                <p>Company: {{$payment->company['name']}}</p>
                            </div>
                            <div class="col-md-6">

                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th width="80%">Item</th>
                                        <th width="20%" style="text-align: right;padding-right: 10px">Amount </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($payment->Payment_details as $paymentDetail)
                                        <tr>
                                            <td>{{$paymentDetail->item_name}}</td>
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
                            </div>
                        </div>


                    </div>
                    @endforeach
                        <div class="line aligncenter">
                            <div class="form-group row">
                                <div class="col-sm-12 col-form-label" align="right">
                                    <a href="{{route('payment')}}" class="btn btn-danger"> Cancel</a>
                                    <button type="submit" class="btn btn-primary" data-original-title="" title=""> <i class="feather icon-save"></i>Save & Confirm</button>
                                </div>
                            </div>
                        </div>
                    </form>


        </div>
    </div>

    </div>
    </div>

@endsection