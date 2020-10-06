
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                {{--Advance Payment Information--}}

                <div class="card-body"
                     style="border: 1px solid #000; margin-bottom: 5px; position: relative; min-height: 430px; padding: 15px">
                    <h5 style="position: absolute; right: 25px; top: 15px">Cr. No. {{$income->income_generate_id}}</h5>
                    <h5 style="position: absolute; left: 25px; top: 15px">
                        Date: {{ date('d-m-Y', strtotime($income->created_at))}}</h5>
                    <h5 style="text-align: center; margin-bottom: 5px; font-size: 20px">Income Voucher</h5>
                    <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">{{$income->company->name}} </h4>
                    <p style="text-align: center;margin-bottom: 5px">{{$income->company->c_address}} </p>
                    <h4 style="text-align: center; font-weight:bold;  margin-bottom: 5px" >{{$income->project['p_name']}}</h4>




                    <div style="padding: 0 10px; clear: both">
                        <hr style="margin-top: 1px; margin-bottom: 10px; border-color: #000000">
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <fieldset style="margin-bottom: 10px">
                                <legend>Transaction Information</legend>


                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="row">
                                            <label style="font-weight: bold; font-size: 18px"
                                                   class="col-md-12 col-form-label" for="company_id">From :
                                                @if($income->income_from=='USER')
                                                    @php
                                                        $user= \App\User::find($income->income_from_ref_id)
                                                    @endphp
                                                    {{$user->name}}

                                                @endif
                                                @if($income->income_from=='COMPANY')
                                                    @php
                                                        $company= \App\Company::find($income->income_from_ref_id)
                                                    @endphp
                                                    {{$company->name}}

                                                @endif
                                                @if($income->income_from=='PROJECT')
                                                    @php
                                                        $project= \App\Project::find($income->income_from_ref_id)
                                                    @endphp
                                                    {{$project->p_name}}

                                                @endif
                                                @if($income->income_from=='CLIENT')
                                                    @php
                                                        $client= \App\Client::find($income->income_from_ref_id)
                                                    @endphp
                                                    {{$client->name}}

                                                @endif
                                                @if($income->income_from=='OTHERS')
                                                    {{$income->income_from_ref_id}}
                                                @endif
                                            </label>

                                        </div>

                                    </div>

                                    @if($income->payment_mode=='CHECK')

                                        <div class="col-md-12">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="check_number">Cheque
                                                    Number: <a href="{{route('check_registry_details',$income->checkRegistry->id)}}">{{$income->checkRegistry->check_number}}</a> </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="company_id">Cheque Date : {{$income->checkRegistry->check_date}}</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="company_id">Transaction Type : {{$income->checkRegistry->check_type}} {{$income->payment_mode}}</label>
                                            </div>
                                        </div>
                                    @endif
                                    @if($income->payment_mode=='CASH')
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="check_number">Transaction
                                                    Type: {{$income->payment_mode}}</label>
                                            </div>
                                        </div>
                                    @endif
                                </div>


                            </fieldset>
                        </div>

                        @if($income->payment_mode=='CHECK')
                            <div class="col-md-6">
                                <fieldset>
                                    <legend>Deposit Information</legend>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="company_id">Bank Name : {{$income->checkRegistry->bank->name}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="company_id">Branch Name : {{$income->checkRegistry->branch->name}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="company_id">A/C Number : {{$income->checkRegistry->bankAccount->account_number}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        @endif

                    </div>
                    <div style="padding: 0 10px; clear: both">
                        <hr style="margin-top: 1px; margin-bottom: 10px; border-color: #000000">
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <label style="font-size: 18px; font-weight: bold" class="col-md-12 col-form-label"
                                   for="check_number">Amount: {{number_format($income->amount,2,'.',',')}}</label>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <label class="col-md-12 col-form-label"
                                       for="check_number">Description: {{$income->description}}</label>

                            </div>
                        </div>
                    </div>
                    <div class="row in_word_area">
                        <div class="col-md-12">
                            <label style="font-weight: bold; font-size: 20px" class="col-md-12 col-form-label">In
                                words: <span class="to_word">
                                    @php use App\CustomClass\NumberToWordConverter;
                                    $amount = NumberToWordConverter::convert($income->amount);
                                    @endphp
                                    {{$amount}} only.
                                    </span>
                            </label>
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
