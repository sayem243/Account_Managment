@extends('layout')
@section('title','Income Details Create')
@section('template')
    <div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Income Details</h5>
                    <div class="card-header-right">
                        <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                            <a href="{{route('income_index')}}" class="btn btn-sm  btn-info"><i class="fas fa-angle-double-left"></i> Back</a>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('income_details_store',$income->id)}}" method="post">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_number">Invoice Number <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="Enter invoice number" value="{{$incomeDetails?$incomeDetails->bill_invoice_number:''}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="bill_amount">Bill Amount <span class="required">*</span></label>
                                    <input type="text" class="form-control only-number" id="bill_amount" name="bill_amount" placeholder="Enter bill amount" value="{{$incomeDetails?$incomeDetails->bill_amount:''}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="certifite_amount">Certifite Amount <span class="required">*</span></label>
                                    <input type="text" class="form-control only-number" id="certifite_amount" name="certifite_amount" placeholder="Enter certifite amount" value="{{$incomeDetails?$incomeDetails->certifite_amount:''}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="check_amount">Cheque Amount <span class="required">*</span></label>
                                    <p class="form-control">{{$income?$income->amount:''}}</p>
                                    <input type="hidden" class="form-control only-number" id="check_amount" name="check_amount" style="pointer-events: none" placeholder="Enter check amount" value="{{$income?$income->amount:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sd_amount">S/D Amount</label>
                                    <input type="text" class="form-control only-number" id="sd_amount" name="sd_amount" placeholder="Enter S/D amount" value="{{$incomeDetails?$incomeDetails->sd_amount:''}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="it_amount">I/T Amount</label>
                                    <input type="text" class="form-control only-number" id="it_amount" name="it_amount" placeholder="Enter I/T amount" value="{{$incomeDetails?$incomeDetails->it_amount:''}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vat_amount">VAT Amount</label>
                                    <input type="text" class="form-control only-number" id="vat_amount" name="vat_amount" placeholder="Enter VAT amount" value="{{$incomeDetails?$incomeDetails->vat_amount:''}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="others_amount">Others Amount</label>
                                    <input type="text" class="form-control only-number" id="others_amount" name="others_amount" placeholder="Enter others amount" value="{{$incomeDetails?$incomeDetails->others_amount:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                            </div>
                        </div>

                        <div class="line aligncenter" style="float: right">
                            <div class="form-group row">
                                <div style="padding-right: 3px" class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                    <button style="margin-right: 0" type="submit" class="btn btn-info"> <i class="feather icon-save"></i> Save</button>
                                    {{--<button type="reset" class="btn btn btn-outline-danger" data-original-title="" title=""> <i class="feather icon-refresh-ccw"></i> Cancel</button>--}}
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
            <!-- Input group -->

        </div>
    </div>
    </div>
@endsection
