
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                {{--Advance Payment Information--}}

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-12 col-form-label" for="company_id">Company Name : {{$income->company->name}}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-12 col-form-label" for="company_id">Bank Name : {{$income->checkRegistry->bank->name}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-12 col-form-label" for="company_id">Branch Name : {{$income->checkRegistry->branch->name}}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-12 col-form-label" for="company_id">Bank Account : {{$income->checkRegistry->bankAccount->account_number}}</label>
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
                                    <label class="col-md-12 col-form-label" for="company_id">Description : {{$income->checkRegistry->description}}</label>
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
