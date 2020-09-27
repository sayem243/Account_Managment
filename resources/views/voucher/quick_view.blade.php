
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                {{--Advance Payment Information--}}

                {{--<div class="card-body"--}}
                     {{--style="border: 1px solid #000; margin-bottom: 5px; position: relative; min-height: 430px; padding: 15px">--}}
                    {{--<h5 style="position: absolute; right: 25px; top: 15px">Cr. No. {{$voucher->voucher_generate_id}}</h5>--}}
                    {{--<h5 style="position: absolute; left: 25px; top: 15px">--}}
                        {{--Date: {{date('d-m-Y', strtotime($voucher->created_at))}}</h5>--}}
                    {{--<h5 style="text-align: center; margin-bottom: 5px; font-size: 20px">Expense Voucher</h5>--}}
                    {{--<h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">{{$voucher->VoucherItems[0]->project->company['name']}}</h4>--}}
                    {{--<p style="text-align: center;margin-bottom: 5px">{{$voucher->VoucherItems[0]->project->company['c_address']}}</p>--}}



                    {{--<div style="padding: 0 10px; clear: both">--}}
                        {{--<hr style="margin-top: 1px; margin-bottom: 10px; border-color: #000000">--}}
                    {{--</div>--}}

                    <div class="card-body">
                        <div class="card-body" style="border: 1px solid #000; margin-bottom: 5px; position: relative; min-height: 450px">
                            <h5 style="position: absolute; right: 30px; top: 40px">Dr. No. {{$voucher->voucher_generate_id}}</h5>
                            <h5 style="text-align: center; margin-bottom: 5px">Voucher</h5>
                            <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">{{$voucher->VoucherItems[0]->project->company['name']}}</h4>
                            <p style="text-align: center;margin-bottom: 5px">{{$voucher->VoucherItems[0]->project->company['c_address']}}</p>
                            <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">{{$voucher->VoucherItems[0]->project['p_name']}}</h4>

                            <hr style="margin-top: 1px; margin-bottom: 10px">






                            <div class="row">
                                <div class="col-md-9"><h4>Account: {{$voucher->expenditureSector->name}}</h4></div>
                                <div class="col-md-3"><h5>Date: {{ date('d-m-Y', strtotime($voucher->created_at))}}</h5></div>
                            </div>









                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="85%">Item Name</th>
                            <th style="text-align: right; padding-right: 15px" width="15%">Amount (TK.)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $chequeRegistry = array();
                        @endphp
                        @foreach($voucher->VoucherItems as $voucherItem)

                            @if(isset($voucherItem->checkRegistry))
                                @php
                                    $chequeRegistry[] = $voucherItem->checkRegistry;
                                @endphp
                            @endif
                            <tr>
                                <td>{{$voucherItem->item_name}}</td>
                                <td style="text-align: right; padding-right: 15px">{{number_format($voucherItem->voucher_amount,0,'.',',')}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        <tr style="font-weight: bold; font-size: 18px; color: #ff3737;">
                            <td style="text-align: right;padding-right: 10px">Total Taka = </td>
                            <td class="total_amount" style="text-align: right; padding-right: 15px">{{number_format($voucher->total_amount,0,'.',',')}}</td>
                        </tr>
                        </tfoot>

                    </table>

                            <div class="row">
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

                                    @foreach($chequeRegistry as $items)


                                        <div class="row">
                                            <fieldset style="margin-bottom: 17px">
                                                <div class="col-md-12">  <h4>Deposit Information</h4></div>

                                                <div class="col-md-12">  <h5>Bank: {{$items->bank->name}}</h5></div>
                                                <div class="col-md-12"> <h6>Branch: {{$items->branch->name}}</h6></div>
                                                <div class="col-md-12"><h6>Account Number: {{$items->bankAccount->account_number}}</h6></div>
                                                <div class="col-md-12"><h6>Check Number: <a href="{{route('check_registry_details',$items['id'])}}">{{$items['check_number']}}</a> </h6></div>
                                            </fieldset>

                                        </div>


                                    @endforeach
                                @endif
                            </div>





                            <div class="row in_word_area_expense">
                            <div class="row">
                                <fieldset style="margin-bottom: -8px">
                                <div class="col-md-12">
                                    @php use App\CustomClass\NumberToWordConverter;
                               $amount = NumberToWordConverter::convert($voucher->total_amount);
                                    @endphp
                                    <p style="color: #ff3737; padding: 10px 5px; margin-bottom: 5px"><strong style="font-weight: bold">Write in
                                            words: </strong>{{$amount}} only</p>
                                </div>
                                </fieldset>

                            </div>
                            </div>







                </div>

            </div>
        </div>

    </div>
    <style>
        fieldset {
            min-width: 0;
            padding: 10px 18px;
            margin: 0;
            border: none;
        }

        legend {
            display: block;
            width: auto;
            max-width: 100%;
            padding: 0px;
            margin-bottom: 0;
            font-size: 1.2rem;
            line-height: normal;
            color: inherit;
            white-space: normal;
            border-bottom: 1px solid;
            border-radius: 0;
        }

        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            border: none;
            color: #fff;
            -webkit-box-shadow: 0 -3px 10px 0 rgba(0, 0, 0, 0.05);
            box-shadow: 0 -3px 10px 0 rgba(0, 0, 0, 0.05);
            background-color: blue;
        }
    </style>
</div>
