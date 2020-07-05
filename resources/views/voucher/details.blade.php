@extends('layout')
@section('title','Confirm Payment')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
            <div class="card-header">
                <h5> Voucher Details </h5>
                <div class="card-header-right">
                    <div class="btn-group btn-group-lg" role="group"
                         aria-label="Button group with nested dropdown">
                        <a style="border-radius: .3rem" target="_blank"
                           href="{{route('voucher_pdf',$voucher->id)}}"
                           class="btn btn-info btn-lg hidden-print"><i class="fa fa-file-pdf fa-1x"></i> PDF</a>
                        <a style="border-radius: .3rem" target="_blank"
                           href="{{route('voucher_print',$voucher->id)}}"
                           class="btn btn-info btn-lg hidden-print"><i class="fa fa-print fa-1x"></i> Print</a>

                        <a style="border-radius: .3rem" href="{{route('voucher_archive_index')}}" class="btn btn-sm btn-info"><i
                                    class="fas fa-angle-double-left"></i> Back</a>
                    </div>
                </div>
                </div>


                    {{--Advance Payment Information--}}

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
                                @foreach($voucher->VoucherItems as $voucherItem)
                                    <tr>
                                        <td>{{$voucherItem->item_name}}</td>
                                        <td style="text-align: right; padding-right: 15px">{{$voucherItem->voucher_amount}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr style="font-weight: bold; font-size: 18px; color: red;">
                                    <td style="text-align: right;padding-right: 10px">Total Taka = </td>
                                    <td class="total_amount" style="text-align: right; padding-right: 15px">{{$voucher->total_amount}}</td>
                                </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>



        </div>
    </div>

    </div>
    </div>

@endsection
