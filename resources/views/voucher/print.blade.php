@extends('admin.index-pdf')
@section('title','voucher_'.time())
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    @php
                        $chequeRegistry = array();
                    @endphp
                    @foreach($voucher->VoucherItems as $voucherItem)

                        @if(isset($voucherItem->checkRegistry))
                            @php
                                $chequeRegistry[] = $voucherItem->checkRegistry;
                            @endphp
                        @endif

                    @endforeach

                    @if(sizeof($chequeRegistry)>0)
                        @if($chequeRegistry[0]->check_type=='ACCOUNT_TRANSFER')
                            @php
                                $voucherType= '(EFT)';
                            @endphp
                        @else
                            @php
                                $voucherType= '(Check)';
                            @endphp
                        @endif
                    @else
                        @php
                            $voucherType= '(Cash)';
                        @endphp
                    @endif
                    <div class="card-body"
                         style="border: 1px solid #000; margin-bottom: 5px; position: relative; min-height: 460px; padding: 15px">
                        <h5 style="position: absolute; right: 10px; top: 10px">Dr. No. {{$voucher->voucher_generate_id}}</h5>
                        <h5 style="text-align: center; margin-bottom: 0px; font-size: 18px">Expense Voucher {{$voucherType}}</h5>
                        <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px;margin-top: 0px;">{{$voucher->VoucherItems[0]->project->company['name']}}</h4>
                        <p style="text-align: center;margin-bottom: 5px">{{$voucher->VoucherItems[0]->project->company['c_address']}}</p>
                        <h4 style="text-align: left; font-weight: bold; margin-bottom: 5px">{{$voucher->VoucherItems[0]->project['p_name']}}</h4>

                        {{--<hr style="margin-top: 1px; margin-bottom: 5px">--}}

                        <hr style="margin-top: 1px; margin-bottom: 10px">

                        <table class="table" style="margin-bottom: 5px">
                            <tr style="font-size: 20px">
                                <th style="text-align: left; border: none">Account: {{$voucher->expenditureSector->name}}</th>
                                <th style="text-align: right; width: 15%; border: none">
                                    Date: {{ date('d-m-Y', strtotime($voucher->created_at))}}
                                </th>
                            </tr>
                        </table>

                        <table class="table" border="1">
                            <thead style="border: 1px solid #000000">
                            <tr style="border: 1px solid #000000">
                                <th style="border: 1px solid #000000; padding: 5px 10px" width="75%">Item Name</th>
                                <th style="border: 1px solid #000000" style="text-align: center!important; padding-right: 15px" align="center" width="20%">Amount (TK.)</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($voucher->VoucherItems as $voucherItem)
                                <tr>
                                    <td style="padding: 5px 10px">{{$voucherItem->item_name}}</td>
                                    <td style="text-align: right; padding-right: 15px">{{number_format($voucherItem->voucher_amount,2,'.',',')}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr style="font-weight: bold; font-size: 18px;">
                                <td style="border: 1px solid #000000; padding: 5px 10px; text-align: right;padding-right: 10px; color: red;">Total Taka =</td>
                                <td class="total_amount"
                                    style="border: 1px solid #000000; text-align: right; padding-right: 15px; color: red;">{{number_format($voucher->total_amount,2,'.',',')}}</td>
                            </tr>
                            </tfoot>

                        </table>


                        <div class="row">


                            @if(sizeof($chequeRegistry)>0)

                                @foreach($chequeRegistry as $items)

                                    <div class="row">
                                        <h4>Deposit Information</h4>
                                        <h5>Bank: {{$items->bank->name}}</h5>
                                        <h5>Branch: {{$items->branch->name}}</h5>
                                        <h5>Account Number: {{$items->bankAccount->account_number}}</h5>
                                        <h5>Check Number: {{$items['check_number']}}</h5>
                                    </div>

                                @endforeach
                            @endif

                        </div>




                        <div class="row in_word_area">
                            <div class="col-md-12">
                                @php use App\CustomClass\NumberToWordConverter;
                               $amount = NumberToWordConverter::convert($voucher->total_amount);
                                @endphp
                                <p style="color: red; padding: 10px 5px 10px 0; margin-bottom: 5px"><strong style="font-weight: bold">In
                                        words: </strong>{{$amount}} only</p>
                            </div>
                        </div>

                        {{--@if(sizeof($chequeRegistry)>0)--}}
                            {{--@foreach($chequeRegistry as $items)--}}


                                {{--<div class="row">--}}
                                    {{--<div class="col-md-12">  <h6>Bank: {{$items->bank->name}}</h6></div>--}}
                                    {{--<div class="col-md-12"> <h6>Branch: {{$items->branch->name}}</h6></div>--}}
                                    {{--<div class="col-md-12"><h6>Account Number: {{$items->bankAccount->account_number}}</h6>--}}
                                    {{--</div>--}}

                                {{--</div>--}}


                            {{--@endforeach--}}
                        {{--@endif--}}








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
