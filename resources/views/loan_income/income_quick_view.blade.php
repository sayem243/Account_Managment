
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                {{--Advance Payment Information--}}

                <div class="card-body"
                     style="border: 1px solid #000; margin-bottom: 5px; position: relative; min-height: 430px; padding: 15px">
                    <h5 style="position: absolute; right: 10px; top: 10px">Cr. No. {{$income->income_generate_id}}</h5>
                    <h5 style="text-align: center; margin-bottom: 5px">Income Voucher</h5>
                    <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">{{$income->company->name}}</h4>
                    <p style="text-align: center;margin-bottom: 5px">{{$income->company->c_address}}</p>

                    @if($income->payment_mode=='CHECK')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Bank Name : {{$income->checkRegistry->bank->name}}</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Branch Name : {{$income->checkRegistry->branch->name}}</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">A/C Number : {{$income->checkRegistry->bankAccount->account_number}}</label>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-md-12 col-form-label" for="company_id">Check Number : {{$income->checkRegistry->check_number}}</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-md-12 col-form-label" for="company_id">Check Date : {{$income->checkRegistry->check_date}}</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-md-12 col-form-label" for="company_id">Check Type : {{$income->checkRegistry->check_type}}</label>
                            </div>
                        </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Transaction Type : {{$income->checkRegistry->check_mode=='IN'?'Credit':'Debit'}}</label>
                                </div>
                            </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-md-12 col-form-label" for="company_id">From :
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

                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-md-12 col-form-label" for="company_id">Amount : {{$income->amount}}</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Description : {{$income->description}}</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>In words: <span class="to_word">
                                        @php use App\CustomClass\NumberToWordConverter;
                                        $amount = NumberToWordConverter::convert($income->amount);
                                        @endphp
                                    {{$amount}}
                                    </span></h4>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
