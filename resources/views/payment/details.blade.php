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

                                <div class="col-md-10 hidden-print" style="text-align: right">

                                    @if($payment->status==3 && auth()->user()->can('payment-paid'))
                                        <button data-id-id="{{$payment->id}}" type="button" class="btn btn-lg btn-primary payment_paid">Disburse</button>
                                    @endif
                                    @if($payment->status==4 && auth()->user()->can('payment-settlement-create') && $payment->total_paid_amount > $totalSettlementAmount)
                                            <button id="addTag" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalForm">
                                                Settlement
                                            </button>
                                    @endif

                                </div>
                            </div>

                </div>
            </div>

        </div>
    </div>

    <div id="modalForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Settlement</h4>
                </div>
                @if($payment->status==4)
                <form class="tagForm" id="tag-form" action="{{ route('settlement_store',$payment->id)}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <label for="settlement_amount">Amount: </label>
                        <input id="settlement_amount" class="form-control" name="settlement_amount" type="number" min="1" max="{{$payment->total_paid_amount - $totalSettlementAmount}}" value="{{$payment->total_paid_amount - $totalSettlementAmount}}" required/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <input id="tag-form-submit" type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
                    @else
                    <p>This payment is not permission</p>
                @endif
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
                            if (data.status == 100) {
                                {
                                    jQuery(elements).remove();
                                    location.reload(true);
                                }
                            }
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