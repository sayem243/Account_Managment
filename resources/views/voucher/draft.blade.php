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

                    {{--Advance Payment Information--}}
                    @foreach($vouchers as $voucher)


                    <div class="card-body" style="border: 1px solid #000; margin-bottom: 5px;">
                        <input type="hidden" value="{{$voucher->id}}" name="voucher_id[]">
                        <h5 style="text-align: center; margin-bottom: 5px">Voucher</h5>
                        <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">{{$voucher->VoucherItems[0]->project->company['name']}}</h4>
                        <p style="text-align: center;margin-bottom: 5px">{{$voucher->VoucherItems[0]->project->company['c_address']}}</p>

                        <hr style="margin-top: 1px; margin-bottom: 10px">
                        {{$voucher->id}}
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
