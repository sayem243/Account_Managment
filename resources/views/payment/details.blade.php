@extends('layout')
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
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-5">
                                <h5>Company: {{$payment->company['name']}}</h5>
                                <h5>Project: {{$payment->project['p_name']}}</h5>
                            </div>
                            <div class="col-md-4">
                                <h4>HS ID: {{$payment->payment_id}}</h4>
                            </div>
                            <div class="col-md-3" style="text-align: right">
                                <h4>Date: {{ date('d-m-Y', strtotime($payment->created_at))}}</h4>
                                <h4 style="color: red">Total Amount: {{$payment->total_paid_amount}}</h4>
                            </div>
                        </div>
                        <hr style="margin-top: 1px; margin-bottom: 10px">
                        <div class="row">
                            <div class="col-md-5">

                                <p>Name: {{$payment->user['name']}}</p>
                                <p>Created By: {{$payment->userCreatedBy['name']}}</p>
                                <p>Verified By: {{$payment->verifiedBy?$payment->verifiedBy['name']:''}}</p>
                                <p>Approved By: {{$payment->approvedBy?$payment->approvedBy['name']:''}}</p>
                                <p>Disbursed By: {{$payment->disbursedBy?$payment->disbursedBy['name']:''}}</p>

                                <div class="signature_area" style="border: 1px solid #000000; height: 60px; width: 250px;text-align: center">
                                    Signature

                                </div>
                            </div>
                            <div class="col-md-7">

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
                                    <tr style="font-weight: bold; font-size: 18px; color: red">
                                        <td style="text-align: right;padding-right: 10px">Total Settlement</td>
                                        <td style="text-align: right;padding-right: 10px">{{$totalSettlementAmount}}</td>
                                    </tr>
                                    <tr style="font-weight: bold; font-size: 18px; color: red">
                                        <td style="text-align: right;padding-right: 10px">Due</td>
                                        <td style="text-align: right;padding-right: 10px">{{$payment->total_paid_amount-$totalSettlementAmount}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @php use App\CustomClass\NumberToWordConverter;
                               $amount = NumberToWordConverter::convert($payment->total_paid_amount);
                                @endphp
                                <p style="color: red; padding: 10px 5px"><strong style="font-weight: bold">Write in words: </strong>{{$amount}} only</p>
                            </div>
                        </div>
                        <div class="row hidden-print" style="float: right">
                            <div style="padding-right: 3px" class="col-sm-12 col-form-label btn-group btn-group-lg hidden-print">

                                @if($payment->status==3 && auth()->user()->can('payment-paid'))
                                    <button style="border-radius: .3rem" data-id-id="{{$payment->id}}" type="button" class="btn btn-lg btn-info payment_paid">Disburse</button>
                                @endif
                                @if($payment->status>3 && auth()->user()->can('payment-settlement-create') && $payment->total_paid_amount > $totalSettlementAmount)
                                    <button style="border-radius: .3rem" id="addTag" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalForm">
                                        Settlement
                                    </button>
                                @endif
                                @if(($payment->status==4 || $payment->status==5) && $payment->total_paid_amount > $totalSettlementAmount)
                                    <button style="border-radius: .3rem" id="addRetried" class="btn btn-info btn-lg" data-toggle="modal" data-target="#retriedModalForm">
                                        Retried
                                    </button>
                                @endif

                                    <a style="border-radius: .3rem" target="_blank" href="{{route('printPDF',$payment->id)}}" class="btn btn-info btn-lg hidden-print"><i class="fa fa-file-pdf fa-1x"></i> PDF</a>
                                    <a style="border-radius: .3rem" target="_blank" href="{{route('payment_print',$payment->id)}}" class="btn btn-info btn-lg hidden-print"><i class="fa fa-print fa-1x"></i> Print</a>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 hidden-print">
                        @if(sizeof($payment->paymentSettlements)>0)

                            <h3>Settlement History</h3>

                            <table class="table table-bordered">
                                <thead>
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                </thead>

                                @php $i=0; @endphp
                                @foreach($payment->paymentSettlements as $paymentSettlement)
                                    @php $i++ @endphp
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date('d-m-Y',strtotime($paymentSettlement->created_at))}}</td>
                                        <td>{{$paymentSettlement->type}}</td>
                                        <td>{{$paymentSettlement->settlement_amount}}</td>
                                    </tr>
                                @endforeach

                            </table>

                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
{{--settlement modal--}}
    <div id="modalForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Settlement</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-5">
                        Total Advance Amount: {{$payment->total_paid_amount}}
                    </div>
                    <div class="col-xs-6">
                        Total Settles Amount: {{$totalSettlementAmount}}
                    </div>
                    @if($payment->status==4||$payment->status==5)
                        <form class="tagForm" id="tag-form" action="{{ route('settlement_store',$payment->id)}}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <label for="settlement_amount">Amount: </label>
                                <input id="settlement_amount" class="form-control" name="settlement_amount" type="number" min="1" max="{{$payment->total_paid_amount - $totalSettlementAmount}}" value="{{$payment->total_paid_amount - $totalSettlementAmount}}" required/>
                            </div>
                            <div class="modal-footer btn-group btn-group-lg">
                                <button style="border-radius: .3rem" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button style="border-radius: .3rem" id="tag-form-submit" type="submit" class="btn btn-info">Save</button>
                            </div>
                        </form>
                    @else
                        <p>This payment is not permission</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{--transfer modal--}}
    <div id="retriedModalForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="retriedModalForm" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Retired</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-5">
                        Total Advance Amount: {{$payment->total_paid_amount}}
                    </div>
                    <div class="col-xs-6">
                        Total Settles Amount: {{$totalSettlementAmount}}
                    </div>
                    @if($payment->status==4||$payment->status==5)
                        <form class="retriedForm" id="retried-form" action="{{ route('transferred_store',$payment->id)}}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="transfer_amount">Amount: </label>
                                        <input id="transfer_amount" class="form-control" name="transfer_amount" type="number" min="1" max="{{$payment->total_paid_amount - $totalSettlementAmount}}" value="{{$payment->total_paid_amount - $totalSettlementAmount}}" required/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="retried_type">Retried Type: </label>
                                        <select class="form-control retried_type" name="retried_type" id="retried_type">
                                            <option value="RETURN">Cash Return</option>
                                            <option value="TRANSFER">Transfer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer btn-group btn-group-lg">
                                <button style="border-radius: .3rem" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button style="border-radius: .3rem" id="tag-form-submit" type="submit" class="btn btn-info">Save</button>
                            </div>
                        </form>
                    @else
                        <p>This payment is not permission</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

@endsection


@section('footer.scripts')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery(document).on("click",".payment_paid",function(a){
                var elements = a.target;
                a.preventDefault();
                var id = jQuery(this).attr('data-id-id');
                if(confirm("Do You want to Payment Paid ?")) {

                    jQuery.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: '/payment/status/paid/' + id,
                        data: {},
                        success: function (data) {

                            if (data.status == 200) {
                                jQuery('.alert').addClass('alert-success').show();
                                jQuery('.alert').find('.message').html(data.message);
                                jQuery(elements).remove();
                            }else{
                                jQuery('.alert').addClass('alert-danger').show();
                                jQuery('.alert').find('.message').html(data.message);
                            }
                            location.reload(true);
                        }

                    });
                }
            });

            jQuery('#aaddTag').click(function(e) {
                e.preventDefault();
                jQuery('#mymodal').modal();
            });
            $('.modal').on('hidden.bs.modal', function(){
                $(this).find('form')[0].reset();
            });
        })
    </script>
@endsection