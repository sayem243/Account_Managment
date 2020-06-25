@extends('layout')
@section('title','Confirm Payment')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
            <div class="card-header">
                <h5> Payment Details </h5>

                </div>

                    <form class="form-horizontal" action="{{ route('payment_store_confirm')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                    {{--Advance Payment Information--}}
                    @foreach($payments as $payment)


                    <div class="card-body" style="border: 1px solid #000; margin-bottom: 5px;">
                        <input type="hidden" value="{{$payment->id}}" name="payment_id[]">
                        <div class="row">
                            <div class="col-md-5">
                                <h5>Company: {{$payment->company['name']}}</h5>
                                <h5>Project: {{$payment->project['p_name']}}</h5>
                            </div>
                            <div class="col-md-4">
                                <h4>HS ID: {{$payment->payment_id}}</h4>
                            </div>
                            <div class="col-md-3" style="text-align: right">
                                <h4>Date: {{ date('d-m-Y', strtotime($payment->created_at))}}</h4>
                                <h4 style="color: red">Total Amount: {{$payment->total_paid_amount}}</h4>
                            </div>
                        </div>
                        <hr style="margin-top: 1px; margin-bottom: 10px">
                        <div class="row">
                            <div class="col-md-5">
                                <p>Name: {{$payment->user['name']}}</p>
                                <p>Created By: {{$payment->userCreatedBy['name']}}</p>
                                <p>Verified By: {{$payment->verifiedBy?$payment->verifiedBy['name']:''}}</p>
                                <p>Approved By: {{$payment->approvedBy?$payment->approvedBy['name']:''}}</p>
                                <p>Disbursed By: {{$payment->disbursedBy?$payment->disbursedBy['name']:''}}</p>

                                <div class="signature_area" style="border: 1px solid #000000; height: 60px; width: 250px;text-align: center">
                                    Signature

                                </div>

                                <table class="table payment_attachment_table" style="margin-top: 25px; margin-bottom: 0">
                                    <tbody>
                                    <tr>
                                        <td><input type="file" name="payment_attachment[{{$payment->id}}][]"></td>
                                        <td>
                                            <button type="button" class="btn btn-info add_row">Add</button>
                                            <button type="button" class="btn btn-danger remove_row" style="display: none">Delete</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-7">

                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th width="80%">Item</th>
                                        <th width="20%" style="text-align: right;padding-right: 10px">Amount </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($payment->Payment_details as $paymentDetail)
                                        <tr>
                                            <td>{{$paymentDetail->item_name}}</td>
                                            <td style="text-align: right;padding-right: 10px">{{$paymentDetail->paid_amount}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr style="font-weight: bold; font-size: 18px; color: red">
                                        <td style="text-align: right;padding-right: 10px">Total</td>
                                        <td style="text-align: right;padding-right: 10px">{{$payment->total_paid_amount}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                        <div class="line aligncenter" style="float: right">
                            <div class="form-group">
                                <div style="padding-right: 1px" class="col-sm-12 col-form-label btn-group-lg" align="right">
                                    <a href="{{route('payment')}}" class="btn btn-danger"> Cancel</a>
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
            $(document).on('click', '.add_row', function(){
                var $tr = $(this).closest('tr');
                $tr.clone().insertAfter($tr);
                $tr.find('td').find('button.remove_row').show();
                $tr.find('td').find('button.add_row').hide();
            });

            // Find and remove selected table rows
            $('body').on('click','.remove_row', function(){
                $(this).closest("tr").remove();
            });
        });
    </script>
@endsection