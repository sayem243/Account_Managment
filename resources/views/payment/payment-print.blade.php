@extends('admin.index-pdf')
@section('title','hand_slip_'.time())
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <table class="table" style="margin-bottom: 0px">
                                <thead>
                                <tr>
                                    <td style="vertical-align: top">
                                        <h5 style="margin-bottom: 8px">Company: {{$payment->company['name']}}</h5>
                                        <h5>Project: {{$payment->project['p_name']}}</h5>
                                    </td>
                                    <td style="vertical-align: top">
                                        <h4>HS ID: {{$payment->payment_id}}</h4>
                                    </td>
                                    <td style="vertical-align: top" align="right">
                                        <h4>Date: {{ date('d-m-Y', strtotime($payment->created_at))}}</h4>
                                        <h4 style="color: red">Total Amount: {{number_format($payment->total_paid_amount,2,'.',',')}}</h4>
                                    </td>
                                </tr>
                                </thead>
                            </table>

                        </div>
                        {{--<hr style="margin-top: 1px; margin-bottom: 10px">--}}
                        <div class="row" style="position: relative">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td width="40%" style="vertical-align: top">
                                        <h5 style="margin-bottom: 8px">Name: {{$payment->user['name']}}</h5>
                                        <p>Created By: {{$payment->userCreatedBy['name']}}</p>
                                        <p>Verified By: {{$payment->verifiedBy?$payment->verifiedBy['name']:''}}</p>
                                        <p>Approved By: {{$payment->approvedBy?$payment->approvedBy['name']:''}}</p>
                                        <p>Disbursed By: {{$payment->disbursedBy?$payment->disbursedBy['name']:''}}</p>


                                    </td>
                                    <td width="60%" style="vertical-align: top">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="padding: 5px 10px 10px; border: none;" align="left" width="75%">Item</th>
                                                <th style="border: none;text-align: right;padding-right: 10px; padding-bottom: 10px">Amount </th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @php $i=0; @endphp
                                            @foreach($payment->Payment_details as $paymentDetail)
                                                <tr>
                                                    <td style="padding: 2px 5px">{{$paymentDetail->item_name}}</td>
                                                    <td style="text-align: right;padding-right: 10px">{{number_format($paymentDetail->paid_amount,2,'.',',')}}</td>
                                                </tr>
                                                @php $i++; @endphp
                                                @if($i==10)
                                                    <tr>
                                                        <td style="padding: 0px 5px 7px" align="center" colspan="3">more ...</td>
                                                    </tr>
                                                    @break
                                                @endif

                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr style="font-weight: bold; font-size: 18px; color: red">
                                                <td style="text-align: right;padding-right: 10px">Total</td>
                                                <td style="text-align: right;padding-right: 10px">{{number_format($payment->total_paid_amount,2,'.',',')}}</td>
                                            </tr>
                                            <tr style="font-weight: bold; font-size: 18px; color: red">
                                                <td style="text-align: right;padding-right: 10px">Total Settlement</td>
                                                <td style="text-align: right;padding-right: 10px">{{number_format($totalSettlementAmount,2,'.',',')}}</td>
                                            </tr>
                                            <tr style="font-weight: bold; font-size: 18px; color: red">
                                                <td style="text-align: right;padding-right: 10px">Due</td>
                                                <td style="text-align: right;padding-right: 10px">{{number_format($payment->total_paid_amount-$totalSettlementAmount,2,'.',',')}}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                            <div class="col-md-12" style="position: absolute; left: 0; top: 300px">
                                <div class="signature_area" style="border: 2px solid #000000; height: 60px; width: 250px;text-align: center;margin-bottom: 10px">
                                    Signature

                                </div>
                                @php use App\CustomClass\NumberToWordConverter;
                               $amount = NumberToWordConverter::convert($payment->total_paid_amount);
                                @endphp
                                <p style="color: red;"><strong style="font-weight: bold">In words: </strong>{{$amount}} only</p>
                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div>

@endsection
@section('footer.scripts')

    <script type="text/javascript">
        jQuery(document).ready(function () {
            window.print();
            setTimeout(function() { window.close(); }, 100);
        });


    </script>
@endsection