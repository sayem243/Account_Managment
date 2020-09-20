@extends('admin.index-pdf')
@section('title','check_registry_'.time())
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    {{--Advance Payment Information--}}

                    <div class="card-body"
                         style="border: 1px solid #000; margin-bottom: 5px; position: relative; min-height: 430px; padding: 15px">
                        @if($checkRegistry->ref_type=='EXPENSE' && $checkRegistry->ref_id !='')
                            @php
                                $voucher= \App\Voucher::find($checkRegistry->ref_id)
                            @endphp

                            <h5 style="position: absolute; right: 25px; top: 15px">Dr. No. {{$voucher->voucher_generate_id}}</h5>

                        @endif
                        <h5 style="position: absolute; left: 25px; top: 15px">
                            Date: {{ date('d-m-Y', strtotime($checkRegistry->created_at))}}</h5>
                        <h5 style="text-align: center; margin-bottom: 5px; font-size: 20px">Expenses Voucher</h5>
                        <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">{{$checkRegistry->company->name}}</h4>
                        @if($checkRegistry->project)
                            <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">{{$checkRegistry->project?$checkRegistry->project->p_name:''}}</h4>
                        @endif
                        <p style="text-align: center;margin-bottom: 5px">{{$checkRegistry->company->c_address}}</p>

                        <div style="padding: 0 10px; clear: both">
                            <hr style="margin-top: 1px; margin-bottom: 10px; border-color: #000000">
                        </div>

                        <div class="row">
                            <table class="table">
                                <tr>
                                    <td style="border: none">
                                        <div class="col-md-6">
                                            <fieldset style="margin-bottom: 10px">
                                                <legend>Transaction Information</legend>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <label style="font-weight: bold; font-size: 18px"
                                                                   class="col-md-12 col-form-label" for="company_id">To :
                                                                @if($checkRegistry->from_to_type=='USER')
                                                                    @php
                                                                        $user= \App\User::find($checkRegistry->from_to_value)
                                                                    @endphp
                                                                    {{$user->name}}

                                                                @endif
                                                                @if($checkRegistry->from_to_type=='COMPANY')
                                                                    @php
                                                                        $company= \App\Company::find($checkRegistry->from_to_value)
                                                                    @endphp
                                                                    {{$company->name}}

                                                                @endif
                                                                @if($checkRegistry->from_to_type=='PROJECT')
                                                                    @php
                                                                        $project= \App\Project::find($checkRegistry->from_to_value)
                                                                    @endphp
                                                                    {{$project->p_name}}

                                                                @endif
                                                                @if($checkRegistry->from_to_type=='CLIENT')
                                                                    @php
                                                                        $client= \App\Client::find($checkRegistry->from_to_value)
                                                                    @endphp
                                                                    {{$client->name}}

                                                                @endif
                                                                @if($checkRegistry->from_to_type=='OTHERS')
                                                                    {{$checkRegistry->from_to_value}}
                                                                @endif
                                                            </label>

                                                        </div>

                                                    </div>


                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <label class="col-md-12 col-form-label" for="check_number">Check
                                                                Number: {{$checkRegistry->check_number}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <label class="col-md-12 col-form-label" for="company_id">Check Date : {{$checkRegistry->check_date}}</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <label class="col-md-12 col-form-label" for="company_id">Transaction Type : CHECK {{$checkRegistry->check_type}}</label>
                                                        </div>
                                                    </div>
                                                </div>


                                            </fieldset>
                                        </div></td>
                                    <td style="vertical-align: top;border: none">
                                        <div class="col-md-6">
                                            <fieldset>
                                                <legend>Deposit Information</legend>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <label class="col-md-12 col-form-label" for="company_id">Bank Name : {{$checkRegistry->bank->name}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <label class="col-md-12 col-form-label" for="company_id">Branch Name : {{$checkRegistry->branch->name}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <label class="col-md-12 col-form-label" for="company_id">A/C Number : {{$checkRegistry->bankAccount->account_number}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </td>
                                </tr>
                            </table>



                        </div>
                        <div style="padding: 0 10px; clear: both">
                            <hr style="margin-top: 1px; margin-bottom: 10px; border-color: #000000">
                        </div>


                        <div class="row">
                            <table class="table">
                                <tr>
                                    <td style="border: none">
                                        <fieldset>
                                        <div class="col-md-6">
                                            <label style="font-size: 18px; font-weight: bold" class="col-md-12 col-form-label"
                                                   for="check_number">Amount: {{number_format($checkRegistry->amount,'0','.',',')}}</label>
                                        </div>
                                        </fieldset>
                                    </td>
                                    <td style="border: none">
                                        <fieldset>
                                        <div class="col-md-6">
                                            <div class="">
                                                <label class="col-md-12 col-form-label"
                                                       for="check_number">Description: {{$checkRegistry->remarks}}</label>

                                            </div>
                                        </div>
                                        </fieldset>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="row in_word_area">
                            <div class="col-md-12">
                                <fieldset>
                                    <label style="font-weight: bold; font-size: 20px" class="col-md-12 col-form-label">In
                                        words: <span class="to_word">
                                    @php use App\CustomClass\NumberToWordConverter as NumberToWordConverterAlias;
                                    $amount = NumberToWordConverterAlias::convert($checkRegistry->amount);
                                    @endphp
                                            {{$amount}}
                                    </span>
                                    </label>
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
                padding: 5px 10px;
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

@endsection


@section('footer.scripts')

    <script type="text/javascript">
        jQuery(document).ready(function () {
            window.print();
            setTimeout(function() { window.close(); }, 100);
        });

    </script>
@endsection