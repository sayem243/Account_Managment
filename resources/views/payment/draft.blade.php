@extends('admin.index')
@section('title','Confirm Payment')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
            <div class="card-header">
                <h5> Payment Details </h5>

                <div class="card-header-right">
                    <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                        <a href="{{route('payment')}}" class="btn btn-sm  btn-info"><i class="fas fa-angle-double-left"></i> Back</a>
                    </div>
                </div>
                </div>

                    <form class="form-horizontal" action="{{ route('payment_store_confirm')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                    {{--Advance Payment Information--}}
                    @foreach($payments as $payment)

                        <input type="hidden" value="{{$payment->id}}" name="payment_id[]">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Company Name: {{$payment->company['name']}}</h4>
                            </div>
                            <div class="col-md-6">
                                <h4>Date: {{ date('d-m-Y', strtotime($payment->created_at))}}</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Payment ID: {{$payment->payment_id}}</h4>
                                <p>Name: {{$payment->user['name']}}</p>
                                <p>Total Amount: {{$payment->total_paid_amount}}</p>
                                <p>Created By: {{$payment->userCreatedBy['name']}}</p>
                                <p>Verified By: {{$payment->verifiedBy?$payment->verifiedBy['name']:''}}</p>
                                <p>Approved By: {{$payment->approvedBy?$payment->approvedBy['name']:''}}</p>
                                <p>Disbursed By: {{$payment->disbursedBy?$payment->disbursedBy['name']:''}}</p>

                                <div class="signature_area" style="border: 1px solid #000000; height: 60px; width: 250px;text-align: center">
                                    Signature

                                </div>
                            </div>
                            <div class="col-md-6">

                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Item</th>
                                        <th>Project</th>
                                        <th>Amount </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($payment->Payment_details as $paymentDetail)
                                        <tr>
                                            <td>{{$paymentDetail->item_name}}</td>
                                            <td>{{$paymentDetail->project['p_name']}}</td>
                                            <td>{{$paymentDetail->paid_amount}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr style="font-weight: bold">
                                        <td colspan="2" align="center">Total</td>
                                        <td>{{$payment->total_paid_amount}}</td>
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
                                    <button type="submit" class="btn btn-primary" data-original-title="" title=""> <i class="feather icon-save"></i>Save</button>
                                    {{--<button type="reset" class="btn btn btn-outline-danger" data-original-title="" title=""> <i class="feather icon-refresh-ccw"></i> Cancel</button>--}}
                                </div>
                            </div>
                        </div>
                    </form>


        </div>
    </div>

    </div>
    </div>

@endsection