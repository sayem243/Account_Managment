@extends('admin.index-pdf')
@section('title','voucher_'.time())
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    {{--Advance Payment Information--}}

                    <div class="card-body"
                         style="border: 1px solid #000; margin-bottom: 5px; position: relative; min-height: 430px; padding: 15px">
                        <h5 style="position: absolute; right: 10px; top: 10px">Dr./Cr.
                            No. {{$voucher->voucher_generate_id}}</h5>
                        <h5 style="text-align: center; margin-bottom: 5px">Voucher</h5>
                        <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">{{$voucher->VoucherItems[0]->project->company['name']}}</h4>
                        <p style="text-align: center;margin-bottom: 5px">{{$voucher->VoucherItems[0]->project->company['c_address']}}</p>
                        <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">{{$voucher->VoucherItems[0]->project['p_name']}}</h4>

                        <hr style="margin-top: 1px; margin-bottom: 5px">
                        <table class="table" style="margin-bottom: 5px">
                            <tr>
                                <th>Account: {{$voucher->expenditureSector->name}}</th>
                                <th style="text-align: right; width: 15%">
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
                                    <td style="text-align: right; padding-right: 15px">{{$voucherItem->voucher_amount}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr style="font-weight: bold; font-size: 18px;">
                                <td style="border: 1px solid #000000; padding: 5px 10px; text-align: right;padding-right: 10px; color: red;">Total Taka =</td>
                                <td class="total_amount"
                                    style="border: 1px solid #000000; text-align: right; padding-right: 15px; color: red;">{{$voucher->total_amount}}</td>
                            </tr>
                            </tfoot>

                        </table>
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
