@extends('layout')
@section('title','Payment details')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header hidden-print">
                        <h5> Payment Details </h5>

                        <div class="card-header-right">
                            <div class="btn-group btn-group-lg" role="group"
                                 aria-label="Button group with nested dropdown">
                                @if($payment->status>3)
                                    <a style="border-radius: .3rem" target="_blank"
                                       href="{{route('printPDF',$payment->id)}}"
                                       class="btn btn-info btn-lg hidden-print"><i class="fa fa-file-pdf fa-1x"></i> PDF</a>
                                    <a style="border-radius: .3rem" target="_blank"
                                       href="{{route('payment_print',$payment->id)}}"
                                       class="btn btn-info btn-lg hidden-print"><i class="fa fa-print fa-1x"></i> Print</a>
                                @endif
                                <a style="border-radius: .3rem" href="{{route('payment')}}" class="btn btn-sm  btn-info"><i
                                            class="fas fa-angle-double-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-5">
                                <h5 style="{{$payment->company->trashed()?'background-color: #ff4b47; color: #ffffff':''}}">Company: {{$payment->company['name']}}</h5>
                                <h5 style="{{$payment->project->trashed()?'background-color: #ff4b47; color: #ffffff':''}}">Project: {{$payment->project['p_name']}}</h5>
                            </div>
                            <div class="col-md-3">
                                <h4>HS ID: {{$payment->payment_id}}</h4>
                                <h4 style="color: red">Total Amount: {{number_format($payment->total_paid_amount,2,'.',',')}}</h4>
                            </div>
                            <div class="col-md-4" style="text-align: right">
                                <h4>Date: {{ date('d-m-Y', strtotime($payment->created_at))}}</h4>
                                <h4>Disbursed Date: {{ date('d-m-Y', strtotime($payment->disbursed_schedule_date))}}</h4>

                            </div>
                        </div>
                        <hr style="margin-top: 1px; margin-bottom: 10px">
                        <div class="row">
                            <div class="col-md-5">

                                <p style="{{$payment->user->trashed()?'background-color: #ff4b47; color: #ffffff':''}}">Name: {{$payment->user['name']}}</p>
                                <p>Created By: {{$payment->userCreatedBy['name']}}</p>
                                <p>Verified By: {{$payment->verifiedBy?$payment->verifiedBy['name']:''}}</p>
                                <p>Approved By: {{$payment->approvedBy?$payment->approvedBy['name']:''}}</p>
                                <p>Disbursed By: {{$payment->disbursedBy?$payment->disbursedBy['name']:''}}</p>

                                <div class="signature_area"
                                     style="border: 1px solid #000000; height: 60px; width: 250px;text-align: center">
                                    Signature

                                </div>
                            </div>
                            <div class="col-md-7">

                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th width="80%">Item</th>
                                        <th width="20%" style="text-align: right;padding-right: 10px">Amount</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($payment->Payment_details as $paymentDetail)
                                        <tr>
                                            <td>{{$paymentDetail->item_name}}</td>
                                            <td style="text-align: right;padding-right: 10px">{{number_format($paymentDetail->paid_amount,2,'.',',')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr style="font-weight: bold; font-size: 18px; color: red">
                                        <td style="text-align: right;padding-right: 10px">Total</td>
                                        <td style="text-align: right;padding-right: 10px">{{number_format($payment->total_paid_amount,2,'.',',')}}</td>
                                    </tr>
                                    <tr style="font-weight: bold; font-size: 18px; color: #000000; background-color: #e0e0e0">
                                        <td style="text-align: right;padding-right: 10px">Total Settlement</td>
                                        <td style="text-align: right;padding-right: 10px">{{number_format($totalSettlementAmount,2,'.',',')}}</td>
                                    </tr>
                                    <tr style="font-weight: bold; font-size: 18px; color: red">
                                        <td style="text-align: right;padding-right: 10px">Due</td>
                                        <td style="text-align: right;padding-right: 10px">{{number_format($payment->total_paid_amount-$totalSettlementAmount,2,'.',',')}}</td>
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
                                <p style="color: red; padding: 10px 5px; margin-bottom: 5px"><strong style="font-weight: bold">In
                                        words: </strong>{{$amount}} only</p>
                            </div>
                        </div>
                        <div class="row hidden-print">
                            <div style="padding-left: 3px" class="col-sm-6 hidden-print">
                                <div class="col-form-label btn-group btn-group-lg">
                                    @if($payment->status<6)
                                        <button style="border-radius: .3rem" id="addAttachments" class="btn btn-info btn-lg"
                                                data-toggle="modal" data-target="#modalAttachmentForm">
                                            Attachments
                                        </button>
                                        <button style="border-radius: .3rem" id="addComments" class="btn btn-info btn-lg"
                                                data-toggle="modal" data-target="#modalCommentForm">
                                            Comments
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div style="padding-right: 3px; float: right; text-align: right" class="col-sm-6 hidden-print">
                                <div class="col-form-label btn-group-lg card-header-right">
                                    @if($payment->status==3
                                 && auth()->user()->can('payment-paid')
                                 && !$payment->user->trashed()
                                 && !$payment->company->trashed()
                                 && !$payment->project->trashed())

                                        @if(date("Y-m-d", strtotime("now"))>=date("Y-m-d", strtotime($payment->disbursed_schedule_date)))

                                            @php
                                                $openingBalance= isset($openingBalance[$payment->company['id']])?$openingBalance[$payment->company['id']]->opening_balance:0;

                                                $dailyDr=isset($cashTransactions[$payment->company['id']]['DR'])?array_sum($cashTransactions[$payment->company['id']]['DR']):0;

                                                $dailyCr = isset($cashTransactions[$payment->company['id']]['CR'])?array_sum($cashTransactions[$payment->company['id']]['CR']):0;

                                            @endphp


                                            <div class=" btn-group-lg disbursed_area_button">

                                                @if(($openingBalance+$dailyCr-$dailyDr)>=$payment->total_paid_amount)
                                                    <input type="checkbox" id="is_old_hand_slip" name="is_old" class="is_old_hand_slip" value="1">
                                                    <label class="form-check-label" for="is_old_hand_slip">Is Old</label>
                                                    <button style="border-radius: .3rem; margin: 0" data-id-id="{{$payment->id}}" type="button"
                                                            class="btn btn-lg btn-info payment_paid">Disburse
                                                    </button>

                                                @else
                                                    <input type="checkbox" id="is_old_hand_slip_less_sufficient_balance" name="is_old" class="is_old_hand_slip_less_sufficient_balance" value="1">
                                                    <label class="form-check-label" for="is_old_hand_slip_less_sufficient_balance">Is Old</label>
                                                    <button style="display: none;border-radius: .3rem; margin: 0" data-id-id="{{$payment->id}}" type="button"
                                                            class="btn btn-lg btn-info payment_paid">Disburse
                                                    </button>
                                                    <p style="color: red;padding-right:15px;font-size: 18px">In sufficient balance.</p>
                                                @endif
                                            </div>

                                        @else
                                            <button disabled style="border-radius: .3rem; margin: 0" type="button"
                                                    class="btn btn-lg btn-info">Disburse
                                            </button>

                                        @endif
                                    @endif
                                    @if($payment->status>3 && $payment->status!=7 && auth()->user()->can('payment-settlement-create') && $payment->total_paid_amount > $totalSettlementAmount)
                                        <button style="border-radius: .3rem; margin: 0" id="addTag" class="btn btn-green btn-lg"
                                                data-toggle="modal" data-target="#modalForm">
                                            Settlement
                                        </button>
                                    @endif
                                    @if(($payment->status==4 || $payment->status==5) && auth()->user()->can('payment-settlement-create') && $payment->total_paid_amount > $totalSettlementAmount)
                                        <button style="border-radius: .3rem; margin: 0" id="addRetried" class="btn btn-danger btn-lg"
                                                data-toggle="modal" data-target="#retriedModalForm">
                                            Retrie
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(sizeof($payment->paymentDocuments)>0 || sizeof($payment->paymentComments)>0 || sizeof($payment->paymentSettlements)>0||sizeof($payment->paymentTransfers)>0)
                <div class="card hidden-print">
                    <div class="card-body hidden-print">
                        <div class="row">


                                @if(sizeof($payment->paymentDocuments)>0)
                                <div class="col-sm-6 hidden-print">
                                    <h3>Attachment</h3>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($payment->paymentDocuments as $document)
                                            <tr>
                                                <td>{{date('d-m-Y',strtotime($document->created_at))}}</td>
                                                <td>{{$document->file_name}}</td>
                                                <td><a target="_blank" download href="{{asset($document->file_path)}}">Download</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                                @if(sizeof($payment->paymentComments)>0)
                                    <div class="col-sm-6 hidden-print">
                                        <h3>Comments</h3>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>Comment</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($payment->paymentComments as $comment)
                                                <tr>
                                                    <td style="vertical-align: top">{{date('d-m-Y',strtotime($comment->created_at))}}</td>
                                                    <td style="vertical-align: top">{{$comment->user->name}}</td>
                                                    <td style="vertical-align: top">
                                                        <p style="white-space: normal; margin-bottom: 2px">{{$comment->comments}}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif


                            <div class="col-md-12 hidden-print">

                                @if(sizeof($payment->paymentSettlements)>0||sizeof($payment->paymentTransfers)>0)

                                    <h3>Settlement History</h3>

                                    <table class="table table-bordered">
                                        <thead>
                                        <th>SL.</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        </thead>

                                        @php $i=0; @endphp
                                        @foreach($payment->paymentTransfers as $paymentTransfer)
                                            @php $i++ @endphp
                                            <tr style="color: #000000; background-color: #e0e0e0">
                                                <td>{{$i}}</td>
                                                <td>{{date('d-m-Y',strtotime($paymentTransfer->created_at))}}</td>
                                                <td>TRANSFERRED FROM <a
                                                            href="{{route('details',$paymentTransfer->referencePayment->id)}}">{{$paymentTransfer->referencePayment->payment_id}}</a>
                                                </td>
                                                <td>{{$paymentTransfer->transfer_amount}}</td>
                                            </tr>
                                        @endforeach
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
                @endif
            </div>

        </div>
    </div>
    {{--settlement modal--}}
    <div id="modalForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                        Total Settlement Amount: {{$totalSettlementAmount}}
                    </div>
                    @if($payment->status==4||$payment->status==5)
                        <form class="tagForm" id="payment-settlement-form" action="{{ route('settlement_store',$payment->id)}}"
                              method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <label for="settlement_amount">Amount: </label>
                                <input id="settlement_amount" class="form-control settlement_amount" name="settlement_amount"
                                       type="number" min="1"
                                       max="{{$payment->total_paid_amount - $totalSettlementAmount}}"
                                       value="{{$payment->total_paid_amount - $totalSettlementAmount}}" required/>
                            </div>
                            <div class="modal-footer btn-group btn-group-lg">
                                <button style="border-radius: .3rem" type="button" class="btn btn-danger"
                                        data-dismiss="modal">Close
                                </button>
                                <button style="border-radius: .3rem" id="tag-form-submit-settle" type="submit"
                                        class="btn btn-info payment_settlement_add">Save
                                </button>
                            </div>
                        </form>
                    @else
                        <p>This payment is not permitted</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{--comments modal--}}
    <div id="modalCommentForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Comments</h4>
                </div>
                <div class="modal-body">

                    @if($payment->status<6)
                        <form class="tagForm" id="tag-form" action="{{ route('comments_store',$payment->id)}}"
                              method="post">
                            {{ csrf_field() }}
                                <textarea style="width: 100%" name="comments" id="" cols="30" rows="10" placeholder="Enter your comments"></textarea>
                            <div class="modal-footer btn-group btn-group-lg">
                                <button style="border-radius: .3rem" type="button" class="btn btn-danger"
                                        data-dismiss="modal">Close
                                </button>
                                <button style="border-radius: .3rem" id="tag-form-submit-comment" type="submit"
                                        class="btn btn-info">Save
                                </button>
                            </div>
                        </form>
                    @else
                        <p>This payment is not permission</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{--comments modal--}}
    <div id="modalAttachmentForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Attachments</h4>
                </div>
                <div class="modal-body">

                    @if($payment->status<6)
                        <form class="form-horizontal" action="{{ route('payment_attachment_store', $payment->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table payment_attachment_table" style="margin-top: 25px; margin-bottom: 0">
                                <tbody>
                                <tr>
                                    <td><input type="file" class="payment_attachment" name="payment_attachment[]"></td>
                                    <td>
                                        <button type="button" class="btn btn-info add_row">Add</button>
                                        <button type="button" class="btn btn-danger remove_row" style="display: none">Delete</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modal-footer btn-group btn-group-lg">
                                <button style="border-radius: .3rem" type="button" class="btn btn-danger"
                                        data-dismiss="modal">Close
                                </button>
                                <button style="border-radius: .3rem" id="tag-form-submit-attachment" type="submit"
                                        class="btn btn-info">Save
                                </button>
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
    <div id="retriedModalForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="retriedModalForm" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Retire</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-5">
                        Total Advance Amount: {{$payment->total_paid_amount}}
                    </div>
                    <div class="col-xs-6">
                        Total Settlement Amount: {{$totalSettlementAmount}}
                    </div>
                    @if($payment->status==4||$payment->status==5)
                        <form class="retriedForm" id="retried-form"
                              action="{{ route('transferred_store',$payment->id)}}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="transfer_amount">Amount: </label>
                                        <input id="transfer_amount" class="form-control transfer_amount" name="transfer_amount"
                                               type="number" min="1"
                                               max="{{$payment->total_paid_amount - $totalSettlementAmount}}"
                                               value="{{$payment->total_paid_amount - $totalSettlementAmount}}"
                                               required/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="retried_type">Retrie Type: </label>
                                        <select class="form-control retried_type" name="retried_type" id="retried_type">
                                            <option value="RETURN">Cash Return</option>
                                            <option value="TRANSFER">Transfer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer btn-group btn-group-lg">
                                <button style="border-radius: .3rem" type="button" class="btn btn-danger"
                                        data-dismiss="modal">Close
                                </button>
                                <button style="border-radius: .3rem" id="tag-form-submit-retried" type="submit"
                                        class="btn btn-info retried-button">Save
                                </button>
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
            jQuery(document).on("click", ".payment_paid", function (a) {
                var elements = a.target;
                a.preventDefault();
                var is_old = $(this).closest('.disbursed_area_button').find("input[name='is_old']:checked").val();
                var id = jQuery(this).attr('data-id-id');
                if (confirm("Do You want to Payment Disbursed?")) {

                    jQuery.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: '/payment/status/paid/' + id,
                        data: {is_old:is_old},
                        success: function (data) {

                            if (data.status == 200) {
                                jQuery('.alert').addClass('alert-success').show();
                                jQuery('.alert').find('.message').html(data.message);
                                jQuery(elements).remove();
                                $(".notification_count").load("/notification/refresh");
                            } else {
                                jQuery('.alert').addClass('alert-danger').show();
                                jQuery('.alert').find('.message').html(data.message);
                            }
                            location.reload(true);
                        }

                    });
                }
            });

            $(document).on('click', '.add_row', function(){
                var $tr = $(this).closest('tr');
                $tr.clone().insertAfter($tr);
                $tr.find('td').find('button.remove_row').show();
                $tr.find('td').find('button.add_row').hide();
            });

            // Find and remove selected table rows
            $('body').on('click','.remove_row', function(){
                $(this).closest("tr").remove();
            });

            $(document).on('change', '.payment_attachment', function() {

                //this.files[0].size gets the size of your file.
                var thisValue = this.files[0].size;
                // alert(thisValue);
                    if(thisValue>2048000){
                        alert('Maximum file size 2mb.');
                        $(this).val('');
                    }

            });
            $(document).on('click', '.payment_settlement_add', function() {
                $(this).attr("disabled", true);
                var settlement_amount = $('.settlement_amount').val();
                var settlement_max_amount = $('.settlement_amount').attr('max');
                if(parseFloat(settlement_amount)>parseFloat(settlement_max_amount)){
                    alert('Maximum amount '+settlement_max_amount);
                    $('.settlement_amount').val(settlement_max_amount);
                    $(this).attr("disabled", false);
                    return false;
                }

                $('#payment-settlement-form').submit();

                $(".notification_count").load("/notification/refresh");
            });

            $(document).on('click', '.retried-button', function() {
                $(this).attr("disabled", true);

                var transfer_amount = $('.transfer_amount').val();
                var transfer_max_amount = $('.transfer_amount').attr('max');
                if(parseFloat(transfer_amount)>parseFloat(transfer_max_amount)){
                    alert('Maximum amount '+transfer_max_amount);
                    $('.transfer_amount').val(transfer_max_amount);
                    $(this).attr("disabled", false);
                    return false;
                }

                $('#retried-form').submit();
                $(".notification_count").load("/notification/refresh");
            });

            $('.modal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
                $('.payment_settlement_add').attr("disabled", false);
                $('.retried-button').attr("disabled", false);
            });

            $('.is_old_hand_slip_less_sufficient_balance').click(function() {
                if( $(this).is(':checked')) {
                    $(".payment_paid").show();
                } else {
                    $(".payment_paid").hide();
                }
            });
        })
    </script>
@endsection