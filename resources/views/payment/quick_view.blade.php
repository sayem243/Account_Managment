
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
                                        <h5 >Company: {{$payment->company['name']}}</h5>
                                        <h5>Project: {{$payment->project['p_name']}}</h5>
                                    </td>
                                    <td style="vertical-align: top">
                                        <h4>HS ID: {{$payment->payment_id}}</h4>
                                    </td>
                                    <td style="vertical-align: top" align="right">
                                        <h4>Date: {{ date('d-m-Y', strtotime($payment->created_at))}}</h4>
                                        <h4 style="color: red;">Total Amount: {{$payment->total_paid_amount}}</h4>
                                    </td>
                                </tr>
                                </thead>
                            </table>

                        </div>
                        {{--<hr style="margin-top: 1px; margin-bottom: 5px">--}}
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
                                        <table class="table table-bordered" style="margin-top: 5px">
                                            <thead>
                                            <tr>
                                                <th style="padding: 5px 10px 10px" align="left" width="75%">Item</th>
                                                <th style="text-align: right;padding-right: 10px; padding-bottom: 10px">Amount </th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @php $i=0; @endphp
                                            @foreach($payment->Payment_details as $paymentDetail)
                                                <tr>
                                                    <td style="padding: 2px 5px">{{$paymentDetail->item_name}}</td>
                                                    <td style="text-align: right;padding-right: 10px">{{$paymentDetail->paid_amount}}</td>
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
                                                <td style="text-align: right;padding-right: 10px">{{$payment->total_paid_amount}}</td>
                                            </tr>
                                            <tr style="font-weight: bold; font-size: 18px; color: #000000; background-color: #e0e0e0">
                                                <td style="text-align: right;padding-right: 10px">Total Settlement</td>
                                                <td style="text-align: right;padding-right: 10px">{{$totalSettlementAmount}}</td>
                                            </tr>
                                            <tr style="font-weight: bold; font-size: 18px; color: red">
                                                <td style="text-align: right;padding-right: 10px">Due</td>
                                                <td style="text-align: right;padding-right: 10px">{{$payment->total_paid_amount-$totalSettlementAmount}}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                            <div class="col-md-12">
                                <div class="signature_area" style="border: 2px solid #000000; height: 60px; width: 250px;text-align: center;margin-bottom: 10px">
                                    Signature

                                </div>
                                @php use App\CustomClass\NumberToWordConverter;
                               $amount = NumberToWordConverter::convert($payment->total_paid_amount);
                                @endphp
                                <p style="color: red;"><strong style="font-weight: bold">Write in words: </strong>{{$amount}} only</p>
                            </div>
                        </div>

                    </div>


                </div>

                <div class="card hidden-print">
                    <div class="card-body hidden-print">
                        <div class="row">
                            <div class="col-sm-6 hidden-print">

                                @if(sizeof($payment->paymentDocuments)>0)
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
                                @endif
                            </div>
                            <div class="col-sm-6 hidden-print">

                                @if(sizeof($payment->paymentComments)>0)
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
                                @endif
                            </div>

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


            </div>

        </div>
    </div>
