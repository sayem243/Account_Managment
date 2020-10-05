@extends('layout')
@section('title','Confirm Payment')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
            <div class="card-header">
                <h5> Voucher Details </h5>

                </div>

                    <form class="form-horizontal" action="{{ route('voucher_store_confirm')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{--<input type="hidden" name="check_id" value="{{$check_id?$check_id:''}}">--}}

                    {{--Advance Payment Information--}}
                    @foreach($vouchers as $voucher)


                    <div class="card-body" style="border: 1px solid #000; margin-bottom: 5px; position: relative">
                        <input type="hidden" value="{{$voucher->id}}" name="voucher_id[]">
                        <h5 style="position: absolute; right: 30px; top: 40px">{{$voucher->voucher_generate_id}}</h5>
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
                                <th width="15%">Amount (TK.)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($voucher->VoucherItems as $voucherItem)
                                <tr>
                                    <td>{{$voucherItem->item_name}}</td>
                                    <td><input style="text-align: right" type="text" class="form-control amount" name="voucher_amount[{{$voucher->id}}][{{$voucherItem->id}}]" value="{{$voucherItem->voucher_amount}}"></td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr style="font-weight: bold; font-size: 18px; color: red;">
                                <td style="text-align: right;padding-right: 10px">Total Taka = </td>
                                <td class="total_amount" style="text-align: right; padding-right: 15px">{{number_format($voucher->total_amount,2,'.',',')}}</td>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                    @endforeach
                        <div class="line aligncenter" style="float: right">
                            <div class="form-group">
                                <div style="padding-right: 1px" class="col-sm-12 col-form-label btn-group-lg" align="right">
                                    <a href="{{route('voucher_index')}}" class="btn btn-danger"> Cancel</a>
                                    <button style="margin-right: 0px" type="submit" class="btn btn-info" data-original-title="" title=""> <i class="feather icon-save"></i>Save & Confirm</button>
                                </div>
                            </div>
                        </div>
                    </form>


        </div>
    </div>

    </div>
    </div>

@endsection

@section('footer.scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            calculateSum();
            $(document).on("keypress keyup blur", ".amount", function (e) {
            $(this).val($(this).val().replace(/[^0-9\.]/g,''));
                calculateSum();
            if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
            }
            });
        });

        function calculateSum() {

//iterate through each td based on class and add the values
            $('.total_amount').each(function() {
                var sum = 0;
                $(this).parents('table').find('.amount').each(function() {
                    var floted = parseFloat($(this).val());
                    if (!isNaN(floted)) sum += floted;
                });

                $(this).html(sum);
            });
        }

    </script>

@endsection
