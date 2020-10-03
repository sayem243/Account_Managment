@extends('layout')
@section('title','Daily Cash Balance')
@section('template')


 <div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
       <div class="card">
          <div class="card-header">
              <h3>Daily Cash Balance </h3>
          </div>
      <div class="card-body">
         <table class= "table">
             <thead>
             <tr>
                 <td colspan="5">
                     <form action="">
                         <table class="table" style="margin: 0">
                             <tr>
                                 <td style="width: 50%" colspan="1">
                                     <div class="form-group row" style="margin: 0">
                                         <label for="filter_company_id" class="col-sm-2 col-form-label">Company</label>
                                         <div class="col-sm-10">
                                             <select name="filter_company_id" id="filter_company_id" class="form-control">
                                                 <option value="">All</option>
                                                 @foreach($companies as $key=>$value)
                                                     <option value="{{$key}}" {{(isset($_GET['filter_company_id'])&&$_GET['filter_company_id']==$key)?'selected="selected"':''}}>{{$value}}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>

                                 </td>
                                 <td style="width: 35%" colspan="1">
                                     <div class="form-group row" style="margin: 0">
                                         <label for="filter_date" class="col-sm-2 col-form-label">Date</label>
                                         <div class="col-sm-10">
                                             <input type="date" id="filter_date" name="filter_date" value="{{isset($_GET['filter_date'])?$_GET['filter_date']:''}}" class="form-control">
                                         </div>
                                     </div>
                                 </td>
                                 <td style="width: 15%">
                                     <button type="submit" class="btn btn-primary" >Filter</button>
                                 </td>
                             </tr>
                         </table>
                     </form>
                 </td>
             </tr>
             </thead>
            <tbody>


            <tr>
                <td colspan="5">
                    @if(sizeof($openingBalance)>0)
                        @if($getPreviousCurrentSessionClose)
                    <form action="{{route('closing_balance_update')}}" method="post">

                        {{ csrf_field() }}
                        @endif
                        <table class="table table-bordered" style="margin: 0">
                            <thead>
                            <tr style="background-color: red; color: #FFFFFF; font-weight: bold; font-size: large">
                                <td style="text-align: left" colspan="3">Total Opening Balance</td>
                                <td></td>
                                <td>{{number_format($openingBalanceTotal, 0,'.',',')}}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $totalBalance = 0;
                                $grandCrTotal = 0;
                                $grandDrTotal = 0;
                            @endphp
                            @foreach($company as $step1Key=>$value)

                                @php
                                    $balance = isset($openingBalance[$step1Key])?$openingBalance[$step1Key]->opening_balance:0;
                                    $crTotal = 0;
                                    $drTotal = 0;
                                @endphp

                                @if(isset($cashTransactions[$step1Key]) || (isset($openingBalance[$step1Key]) && $openingBalance[$step1Key]->opening_balance > 0) )
                                <tr>
                                    <td style="background-color: darkgrey; color: #FFFFFF;font-weight: bold; font-size: medium" align="center" colspan="5">{{$value}}</td>
                                </tr>
                                <tr style="color: #FFFFFF; background-color: darkblue; font-weight: bold">
                                    <th style="width: 20%;">Transaction Type</th>
                                    <th style="width: 30%">Description</th>
                                    <th style="width: 15%">Debit (TK.)</th>
                                    <th style="width: 15%">Credit (TK.)</th>
                                    <th style="width: 20%">Balance</th>
                                </tr>
                                <tr style="color: red; font-weight: bold">
                                    <td style="color: black">
                                        Opening Balance
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td style="color: #FFFFFF">{{isset($openingBalance[$step1Key])?number_format($openingBalance[$step1Key]->opening_balance, 0,'.',','):0}}</td>
                                    <td>
                                        {{isset($openingBalance[$step1Key])?number_format($openingBalance[$step1Key]->opening_balance, 0,'.',','):0}}
                                    </td>
                                </tr>

                                @if(isset($cashTransactions[$step1Key]))

                                @foreach($cashTransactions[$step1Key] as $step2Key=>$transType)
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
                                                    <tr style="color: black; font-weight: bold">
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
                                                    <td>{{number_format($data->amount,0,'.',',')}}</td>
                                                    <td>{{number_format($balance,'0','',',')}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @foreach($cashTransactions[$step1Key] as $step2Key=>$transType)
                                    @if($step2Key=='CR')
                                        @php $incomeCr=0 @endphp
                                        @foreach($transType as $data)
                                            @if(in_array($data->transaction_via, array('INCOME_CASH')))
                                                @php
                                                    $balance = $balance+$data->amount;
                                                    $crTotal=$crTotal+$data->amount;
                                                @endphp
                                                @php $incomeCr++ @endphp
                                                @if ($incomeCr==1)
                                                    <tr style="color: black; font-weight: bold">
                                                        <td>Income</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td>{{'Income through cash # '}} @php
                                                            $income= \App\Income::find($data->transaction_via_ref_id)
                                                        @endphp
                                                        <a data-toggle="modal" data-target-income-id="{{$income->id}}" data-target="#myModalIncome" href="javascript:void(0)">{{$income->income_generate_id}}</a></td>
                                                    <td></td>
                                                    <td>{{number_format($data->amount,0,'.',',')}}</td>
                                                    <td>{{number_format($balance,'0','',',')}}</td>
                                                </tr>
                                            @endif

                                            @if(in_array($data->transaction_via, array('INCOME_CHECK_CASH')))
                                                @php
                                                    $balance = $balance+$data->amount;
                                                    $crTotal=$crTotal+$data->amount;
                                                @endphp
                                                @php $incomeCr++ @endphp
                                                @if ($incomeCr==1)
                                                    <tr style="color: black; font-weight: bold">
                                                        <td>Income</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td>{{'Income through cheque # '}} @php
                                                            $income= \App\Income::find($data->transaction_via_ref_id)
                                                        @endphp
                                                        <a data-toggle="modal" data-target-income-id="{{$income->id}}" data-target="#myModalIncome" href="javascript:void(0)">{{$income->income_generate_id}}</a></td>
                                                    <td></td>
                                                    <td>{{number_format($data->amount,0,'.',',')}}</td>
                                                    <td>{{number_format($balance,'0','',',')}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @foreach($cashTransactions[$step1Key] as $step2Key=>$transType)
                                    @php $loanCr=0 @endphp
                                    @if($step2Key=='CR')

                                        @foreach($transType as $data)

                                            @if(in_array($data->transaction_via, array('LOAN_CASH')))
                                                @php
                                                    $balance = $balance+$data->amount;
                                                    $crTotal=$crTotal+$data->amount;
                                                @endphp
                                                @php $loanCr++ @endphp
                                                @if ($loanCr==1)
                                                    <tr style="color: black; font-weight: bold">
                                                        <td>Loan (Credit)</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td>{{'Loan received through # '}}
                                                        @php
                                                            $loan= \App\Loan::find($data->transaction_via_ref_id)
                                                        @endphp
                                                        <a data-toggle="modal" data-target-loan-id="{{$loan->id}}" data-target="#myModalLoan" href="javascript:void(0)">{{$loan->loan_generate_id}}</a>
                                                    </td>
                                                    <td></td>
                                                    <td>{{number_format($data->amount,0,'.',',')}}</td>
                                                    <td>{{number_format($balance,'0','',',')}}</td>
                                                </tr>
                                            @endif

                                            @if(in_array($data->transaction_via, array('LOAN_CHECK_CASH')))
                                                @php
                                                    $balance = $balance+$data->amount;
                                                    $crTotal=$crTotal+$data->amount;
                                                @endphp
                                                @php $loanCr++ @endphp
                                                @if ($loanCr==1)
                                                    <tr style="color: black; font-weight: bold">
                                                        <td>Loan (Credit)</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td>{{'Loan through check # '}} @php
                                                            $loan= \App\Loan::find($data->transaction_via_ref_id)
                                                        @endphp
                                                        <a data-toggle="modal" data-target-loan-id="{{$loan->id}}" data-target="#myModalLoan" href="javascript:void(0)">{{$loan->loan_generate_id}}</a>
                                                    </td>
                                                    <td></td>
                                                    <td>{{number_format($data->amount,0,'.',',')}}</td>
                                                    <td>{{number_format($balance,'0','',',')}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach


                                @foreach($cashTransactions[$step1Key] as $step2Key=>$transType)
                                    @if($step2Key=='CR')
                                        @php $hsSettle=0 @endphp
                                        @foreach($transType as $data)
                                            @if(in_array($data->transaction_via, array('HAND_SLIP_SETTLE','HAND_SLIP_TRANSFER','HAND_SLIP_CASH_RETURN')))
                                                @php
                                                    $balance = $balance+$data->amount;
                                                    $crTotal=$crTotal+$data->amount;
                                                @endphp
                                                @php $hsSettle++ @endphp
                                                @if ($hsSettle==1)
                                                    <tr style="color: black; font-weight: bold">
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
                                                    <td>{{number_format($data->amount,'0','',',')}}</td>
                                                    <td>{{number_format($balance,'0','',',')}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                {{--DR section--}}
                                @foreach($cashTransactions[$step1Key] as $step2Key=>$transType)
                                    @if($step2Key=='DR')
                                        @php $loanDr=0 @endphp
                                        @foreach($transType as $data)

                                            @if($data->transaction_via=='LOAN_CASH')
                                                @php
                                                    $balance = $balance-$data->amount;
                                                    $drTotal = $drTotal+$data->amount;
                                                @endphp
                                                @php $loanDr++ @endphp
                                                @if ($loanDr==1)
                                                    <tr style="color: black; font-weight: bold">
                                                        <td>Loan (Debit)</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        {{'Loan disbursed through # '}} @php
                                                            $loan= \App\Loan::find($data->transaction_via_ref_id)
                                                        @endphp
                                                        <a data-toggle="modal" data-target-loan-id="{{$loan->id}}" data-target="#myModalLoan" href="javascript:void(0)">{{$loan->loan_generate_id}}</a>
                                                    </td>
                                                    <td>{{number_format($data->amount,'0','',',')}}</td>
                                                    <td></td>
                                                    <td>{{number_format($balance,'0','',',')}}</td>
                                                </tr>
                                            @endif

                                            @if($data->transaction_via=='LOAN_CHECK_CASH')
                                                @php
                                                    $balance = $balance-$data->amount;
                                                    $drTotal = $drTotal+$data->amount;
                                                @endphp
                                                @php $loanDr++ @endphp
                                                @if ($loanDr==1)
                                                    <tr style="color: black; font-weight: bold">
                                                        <td>Loan (Debit)</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        {{'Loan through check # '}} @php
                                                            $loan= \App\Loan::find($data->transaction_via_ref_id)
                                                        @endphp
                                                        <a data-toggle="modal" data-target-loan-id="{{$loan->id}}" data-target="#myModalLoan" href="javascript:void(0)">{{$loan->loan_generate_id}}</a>
                                                    </td>
                                                    <td>{{number_format($data->amount,'0','',',')}}</td>
                                                    <td></td>
                                                    <td>{{number_format($balance,'0','',',')}}</td>
                                                </tr>
                                            @endif

                                        @endforeach
                                    @endif
                                @endforeach

                                @foreach($cashTransactions[$step1Key] as $step2Key=>$transType)
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
                                                    <tr style="color: black; font-weight: bold">
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
                                                    <td>{{number_format($data->amount,'0','',',')}}</td>
                                                    <td></td>
                                                    <td>{{number_format($balance,'0','',',')}}</td>
                                                </tr>
                                            @endif

                                        @endforeach
                                    @endif
                                @endforeach

                                @foreach($cashTransactions[$step1Key] as $step2Key=>$transType)
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
                                                    <tr style="color: black; font-weight: bold">
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
                                                    <td>{{number_format($data->amount,'0','',',')}}</td>
                                                    <td></td>
                                                    <td>{{number_format($balance,'0','',',')}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @endif
                                <tr>
                                    <td style="height: 25px"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="color: red; font-weight: bold; margin-bottom: 15px">
                                    <td style="color: black;">Closing Balance</td>
                                    <td></td>
                                    <td>{{number_format($drTotal,'0','',',')}}</td>
                                    <td>{{number_format($crTotal,'0','',',')}}</td>
                                    <td>
                                        {{number_format($balance,'0','',',')}}
                                        <input type="hidden" name="cash_balance_session_id[{{isset($openingBalance[$step1Key])?$openingBalance[$step1Key]->id:null}}]" value="{{$balance}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="height: 0px; border-left: none; border-right: none; padding: 0">
                                        <hr style="margin: 0 0 2px; border: 2px solid #f0f0f0">
                                    </td>
                                </tr>
                                @endif
                                @php
                                    $grandDrTotal = $grandDrTotal+$drTotal;
                                    $grandCrTotal = $grandCrTotal+$crTotal;
                                    $totalBalance = $totalBalance+$balance;
                                @endphp

                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr style="background-color: red; color: #FFFFFF; font-weight: bold; font-size: large">
                                <td style="text-align: center" colspan="2">Total Closing Balance</td>
                                <td>{{number_format($grandDrTotal, 0,'.',',')}}</td>
                                <td>{{number_format($grandCrTotal, 0,'.',',')}}</td>
                                <td>{{number_format($totalBalance, 0,'.',',')}}</td>
                            </tr>
                            </tfoot>
                        </table>
                        @if($getPreviousCurrentSessionClose)
                        <div class="line aligncenter" style="float: right">
                            <div class="form-group row">
                                <div style="padding-right: 3px"
                                     class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                    <input type="hidden" name="selected_date" value="{{$selected_date}}">
                                    <button style="margin-right: 0" name="closing_update" onclick="return confirm('Are you sure?')" value="closing_update" type="submit" class="btn btn-info"><i
                                                class="feather icon-save"></i> End of the day
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                        @endif

                        @else
                        <p style="text-align: center">No record found.</p>

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

 <!-- Modal -->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header" style="display: block">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                 <h4 class="modal-title" id="myModalLabel">Payment Details</h4>
             </div>

             <div class="modal-body">

             </div>


         </div>
     </div>
 </div>

 <div class="modal fade" id="myModalVoucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header" style="display: block">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                 <h4 class="modal-title" id="myModalLabel">Voucher Details</h4>
             </div>

             <div class="modal-body">

             </div>


         </div>
     </div>
 </div>

 <div class="modal fade" id="myModalCheckRegistry" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header" style="display: block">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                 <h4 class="modal-title" id="myModalLabel">Check Registry Details</h4>
             </div>

             <div class="modal-body">

             </div>


         </div>
     </div>
 </div>
 <div class="modal fade" id="myModalLoan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header" style="display: block">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                 <h4 class="modal-title" id="myModalLabel">Loan Details</h4>
             </div>

             <div class="modal-body">

             </div>


         </div>
     </div>
 </div>
 <div class="modal fade" id="myModalIncome" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header" style="display: block">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                 <h4 class="modal-title" id="myModalLabel">Income Details</h4>
             </div>

             <div class="modal-body">

             </div>


         </div>
     </div>
 </div>


 <style>
     .modal-dialog {
         width: 95%;
         max-width: 95%;
         height: 100%;
         padding: 0;
     }

     .modal-content {
         height: auto;
         min-height: 100%;
         border-radius: 0;
     }
 </style>
@endsection
@section('footer.scripts')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#myModal").on("show.bs.modal", function(e) {
                var id = jQuery(e.relatedTarget).data('target-id');
                jQuery.get( "/payment/quick/view/" + id, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });

            jQuery("#myModalVoucher").on("show.bs.modal", function(e) {
                jQuery(".modal-body").html('');
                var id = jQuery(e.relatedTarget).data('target-voucher-id');
                jQuery.get( "/voucher/quick/view/" + id, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });
            jQuery("#myModalCheckRegistry").on("show.bs.modal", function(e) {
                var id = jQuery(e.relatedTarget).data('target-check-registry-id');
                jQuery.get( "/check/registry/quick/view/" + id, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });
            jQuery("#myModalLoan").on("show.bs.modal", function(e) {
                var id = jQuery(e.relatedTarget).data('target-loan-id');
                jQuery.get( "/loan/quick/view/" + id, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });
            jQuery("#myModalIncome").on("show.bs.modal", function(e) {
                var id = jQuery(e.relatedTarget).data('target-income-id');
                jQuery.get( "/income/quick/view/" + id, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });
        });
    </script>
@endsection