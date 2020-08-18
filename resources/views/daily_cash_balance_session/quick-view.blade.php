<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class= "table">
                        <tbody>


                        <tr>
                            <td colspan="5">
                                @if(sizeof($cashTransactions)>0)
                                    <form action="{{route('closing_balance_update')}}" method="post">
                                        {{ csrf_field() }}
                                        <table class="table table-bordered" style="margin: 0">
                                            <tbody>
                                            @foreach($cashTransactions as $step1Key=>$value)
                                                <tr>
                                                    <td style="background-color: darkgrey; color: #FFFFFF;font-weight: bold; font-size: medium" align="center" colspan="5">{{$company[$step1Key]}}</td>
                                                </tr>
                                                <tr style="color: #FFFFFF; background-color: darkblue; font-weight: bold">
                                                    <th style="width: 20%">Transaction Type</th>
                                                    <th style="width: 30%">Description</th>
                                                    <th style="width: 15%">Debit (TK.)</th>
                                                    <th style="width: 15%">Credit (TK.)</th>
                                                    <th style="width: 20%">Balance</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Opening Balance
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{isset($openingBalance[$step1Key])?number_format($openingBalance[$step1Key]->opening_balance, 0,'.',''):0}}</td>
                                                    <td>
                                                        {{isset($openingBalance[$step1Key])?number_format($openingBalance[$step1Key]->opening_balance, 0,'.',''):0}}
                                                    </td>
                                                </tr>
                                                @php
                                                    $balance = isset($openingBalance[$step1Key])?$openingBalance[$step1Key]->opening_balance:0;
                                                    $crTotal = isset($openingBalance[$step1Key])?$openingBalance[$step1Key]->opening_balance:0;
                                                    $drTotal = 0;
                                                @endphp
                                                @foreach($value as $step2Key=>$transType)
                                                    @if($step2Key=='CR')
                                                        @php $checkOut=0 @endphp
                                                        @foreach($transType as $data)
                                                            @if($data->transaction_via=='CHECK_OUT')
                                                                @php
                                                                    $balance = $balance+$data->amount;
                                                                    $crTotal=$crTotal+$data->amount;
                                                                @endphp
                                                                @php $checkOut++ @endphp
                                                                @if ($checkOut==1)
                                                                    <tr>
                                                                        <td>Credit</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td></td>
                                                                    <td>{{'Cash through cheque # '}} @php
                                                                            $checkRegistry= \App\CheckRegistry::find($data->transaction_via_ref_id)
                                                                        @endphp
                                                                        <a data-toggle="modal" data-target-check-registry-id="{{$checkRegistry->id}}" data-target="#myModalCheckRegistry" href="javascript:void(0)">{{$checkRegistry->check_number}}</a></td>
                                                                    <td></td>
                                                                    <td>{{number_format($data->amount,0,'.','')}}</td>
                                                                    <td>{{$balance}}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @foreach($value as $step2Key=>$transType)
                                                    @if($step2Key=='CR')
                                                        @php $hsSettle=0 @endphp
                                                        @foreach($transType as $data)
                                                            @if($data->transaction_via!='CHECK_OUT')
                                                                @php
                                                                    $balance = $balance+$data->amount;
                                                                    $crTotal=$crTotal+$data->amount;
                                                                @endphp
                                                                @php $hsSettle++ @endphp
                                                                @if ($hsSettle==1)
                                                                    <tr>
                                                                        <td>H/S Settle</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td></td>
                                                                    <td>
                                                                        @php
                                                                            $payment= \App\Payment::find($data->transaction_via_ref_id)
                                                                        @endphp
                                                                        {{$payment->user->name}} (H/S # <a data-toggle="modal" data-target-id="{{$payment->id}}" data-target="#myModal" href="javascript:void(0)">{{$payment->payment_id}}</a>)
                                                                    </td>
                                                                    <td></td>
                                                                    <td>{{$data->amount}}</td>
                                                                    <td>{{$balance}}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                {{--DR section--}}
                                                @foreach($value as $step2Key=>$transType)
                                                    @if($step2Key=='DR')
                                                        @php $hsIssue=0 @endphp
                                                        @foreach($transType as $data)

                                                            @if($data->transaction_via=='HAND_SLIP_ISSUE')
                                                                @php
                                                                    $balance = $balance-$data->amount;
                                                                    $drTotal = $drTotal+$data->amount;
                                                                @endphp
                                                                @php $hsIssue++ @endphp
                                                                @if ($hsIssue==1)
                                                                    <tr>
                                                                        <td>H/S Issued</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td></td>
                                                                    <td>
                                                                        @php
                                                                            $payment= \App\Payment::find($data->transaction_via_ref_id)
                                                                        @endphp
                                                                        {{$payment->user->name}} (H/S # <a data-toggle="modal" data-target-id="{{$payment->id}}" data-target="#myModal" href="javascript:void(0)">{{$payment->payment_id}}</a>)
                                                                    </td>
                                                                    <td>{{$data->amount}}</td>
                                                                    <td></td>
                                                                    <td>{{$balance}}</td>
                                                                </tr>
                                                            @endif

                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @foreach($value as $step2Key=>$transType)
                                                    @if($step2Key=='DR')
                                                        @php $vIndex=0 @endphp
                                                        @foreach($transType as $data)
                                                            @if($data->transaction_via=='VOUCHER')
                                                                @php
                                                                    $balance = $balance-$data->amount;
                                                                    $drTotal = $drTotal+$data->amount;
                                                                @endphp
                                                                @php $vIndex++ @endphp
                                                                @if ($vIndex==1)
                                                                    <tr>
                                                                        <td>Voucher</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td></td>
                                                                    <td>
                                                                        @php
                                                                            $voucher= \App\Voucher::find($data->transaction_via_ref_id)
                                                                        @endphp
                                                                        {{$voucher->expenditureSector->name}} (Voucher # <a data-toggle="modal" data-target-voucher-id="{{$voucher->id}}" data-target="#myModalVoucher" href="">{{$voucher->voucher_generate_id}}</a>)
                                                                    </td>
                                                                    <td>{{$data->amount}}</td>
                                                                    <td></td>
                                                                    <td>{{$balance}}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <td style="height: 25px"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr style="font-weight: bold">
                                                    <td>Closing Balance</td>
                                                    <td></td>
                                                    <td>{{$drTotal}}</td>
                                                    <td>{{$crTotal}}</td>
                                                    <td>
                                                        {{$balance}}
                                                        <input type="hidden" name="cash_balance_session_id[{{isset($openingBalance[$step1Key])?$openingBalance[$step1Key]->id:null}}]" value="{{$balance}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" style="height: 15px"></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="line aligncenter" style="float: right">
                                            <div class="form-group row">
                                                <div style="padding-right: 3px"
                                                     class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                                    <input type="hidden" name="selected_date" value="{{$selected_date}}">
                                                    <button style="margin-right: 0" name="closing_update" value="closing_update" type="submit" class="btn btn-info"><i
                                                                class="feather icon-save"></i> End of the day
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                @endif

                            </td>
                        </tr>


                        </tbody>

                    </table>
                </div>





            </div>
        </div>

    </div>
</div>
