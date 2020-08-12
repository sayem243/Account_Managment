@extends('layout')
@section('title','Bank List')
@section('template')


 <div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
       <div class="card">
          <div class="card-header">
              <h3>Daily Cash Balance </h3>
          </div>
      <div class="card-body">
         <table class= "table table-bordered">
            <tbody>

            @foreach($cashTransactions as $step1Key=>$value)
                <tr>
                    <td style="background-color: darkgrey; color: #FFFFFF;font-weight: bold; font-size: medium" align="center" colspan="5">{{$company[$step1Key]}}</td>
                </tr>
                <tr style="color: #FFFFFF; background-color: darkblue; font-weight: bold">
                    <th>Transaction Type</th>
                    <th>Description</th>
                    <th>Debit (TK.)</th>
                    <th>Credit (TK.)</th>
                    <th>Balance</th>
                </tr>
                <tr>
                    <td>
                        Opening Balance
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>0000</td>
                </tr>
                @php
                    $balance = 0;
                    $crTotal = 0;
                    $drTotal = 0;
                @endphp
                @foreach($value as $step2Key=>$transType)
                    @if($step2Key=='CR')
                        @foreach($transType as $data)
                            @if($data->transaction_via=='CHECK_OUT')
                                @php
                                    $balance = $balance+$data->amount;
                                    $crTotal=$crTotal+$data->amount;
                                @endphp
                                <tr>
                                    <td></td>
                                    <td>{{'Cash through cheque'}}</td>
                                    <td></td>
                                    <td>{{$data->amount}}</td>
                                    <td>{{$balance}}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @foreach($value as $step2Key=>$transType)
                    @if($step2Key=='CR')
                        <tr>
                            <td>H/S Settle</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach($transType as $data)
                            @if($data->transaction_via!='CHECK_OUT')
                                @php
                                    $balance = $balance+$data->amount;
                                    $crTotal=$crTotal+$data->amount;
                                @endphp
                                <tr>
                                    <td></td>
                                    <td>{{$data->transaction_via}}</td>
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
                        <tr>
                            <td>H/S Issued</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach($transType as $data)

                            @if($data->transaction_via=='HAND_SLIP_ISSUE')
                                @php
                                    $balance = $balance-$data->amount;
                                    $drTotal = $drTotal+$data->amount;
                                @endphp
                                <tr>
                                    <td></td>
                                    <td>
                                        @php
                                       $payment= \App\Payment::find($data->transaction_via_ref_id)
                                        @endphp
                                        {{$payment->user->name}} (H/S # {{$payment->payment_id}})
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
                        <tr>
                            <td>Voucher</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach($transType as $data)
                            @if($data->transaction_via=='VOUCHER')
                                @php
                                    $balance = $balance-$data->amount;
                                    $drTotal = $drTotal+$data->amount;
                                @endphp
                                <tr>
                                    <td></td>
                                    <td>
                                        @php
                                       $voucher= \App\Voucher::find($data->transaction_via_ref_id)
                                        @endphp
                                        {{$voucher->expenditureSector->name}} (Voucher # {{$voucher->voucher_generate_id}})
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
                    <td>{{$balance}}</td>
                </tr>
                <tr>
                    <td colspan="5" style="height: 15px"></td>
                </tr>
            @endforeach

            </tbody>

            </table>

                </div>





        </div>
    </div>

    </div>
    </div>
@endsection
@section('footer.scripts')
@endsection