
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                {{--Advance Payment Information--}}

                <div class="card-body"
                     style="border: 1px solid #000; margin-bottom: 5px; position: relative; min-height: 430px; padding: 15px">
                    <h5 style="position: absolute; right: 10px; top: 10px">Cr. No. {{$loan->loan_generate_id}}</h5>
                    <h5 style="text-align: center; margin-bottom: 5px">Loan Voucher</h5>
                    <h4 style="text-align: center; font-weight: bold; margin-bottom: 5px">
                        @if($loan->loan_to=='USER')
                            @php
                                $user= \App\User::find($loan->loan_to_ref_id)
                            @endphp
                            {{$user->name}}

                        @endif
                        @if($loan->loan_to=='COMPANY')
                            @php
                                $company= \App\Company::find($loan->loan_to_ref_id)
                            @endphp
                            {{$company->name}}

                        @endif
                        @if($loan->loan_to=='PROJECT')
                            @php
                                $project= \App\Project::find($loan->loan_to_ref_id)
                            @endphp
                            {{$project->p_name}}

                        @endif
                        @if($loan->loan_to=='OTHERS')
                            {{$loan->loan_to_ref_id}}
                        @endif
                    </h4>
                    <p style="text-align: center;margin-bottom: 5px">
                        @if($loan->loan_to=='COMPANY')
                            @php
                                $company= \App\Company::find($loan->loan_to_ref_id)
                            @endphp
                            {{$company->c_address}}

                        @endif
                    </p>
                    <div class="row">

                        <div class="col-md-12">
                            <h4 style="text-align: right">Date: {{ date('d-m-Y', strtotime($loan->created_at))}}</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <fieldset style="margin-bottom: 10px">
                                <legend>From Information</legend>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-12 col-form-label" for="company_id">From :
                                                @if($loan->loan_from=='USER')
                                                    @php
                                                        $user= \App\User::find($loan->loan_from_ref_id)
                                                    @endphp
                                                    {{$user->name}}

                                                @endif
                                                @if($loan->loan_from=='COMPANY')
                                                    @php
                                                        $company= \App\Company::find($loan->loan_from_ref_id)
                                                    @endphp
                                                    {{$company->name}}

                                                @endif
                                                @if($loan->loan_from=='PROJECT')
                                                    @php
                                                        $project= \App\Project::find($loan->loan_from_ref_id)
                                                    @endphp
                                                    {{$project->p_name}}

                                                @endif
                                                @if($loan->loan_from=='OTHERS')
                                                    {{$loan->loan_from_ref_id}}
                                                @endif
                                            </label>

                                        </div>

                                    </div>
                                </div>

                                @if($loan->payment_mode=='CHECK' && $loan->loan_from=='COMPANY')

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="loan_to_bank_id">Bank Name: {{$loan->checkRegistryLoanFrom->bank->name}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="loan_to_branch_id">Branch Name: {{$loan->checkRegistryLoanFrom->branch->name}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="loan_to_bank_account_id">A/C Number: {{$loan->checkRegistryLoanFrom->bankAccount->account_number}}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset>
                                <legend>To Information</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-12 col-form-label" for="company_id">From :

                                                @if($loan->loan_to=='USER')
                                                    @php
                                                        $user= \App\User::find($loan->loan_to_ref_id)
                                                    @endphp
                                                    {{$user->name}}

                                                @endif
                                                @if($loan->loan_to=='COMPANY')
                                                    @php
                                                        $company= \App\Company::find($loan->loan_to_ref_id)
                                                    @endphp
                                                    {{$company->name}}

                                                @endif
                                                @if($loan->loan_to=='PROJECT')
                                                    @php
                                                        $project= \App\Project::find($loan->loan_to_ref_id)
                                                    @endphp
                                                    {{$project->p_name}}

                                                @endif
                                                @if($loan->loan_to=='OTHERS')
                                                    {{$loan->loan_to_ref_id}}
                                                @endif
                                            </label>

                                        </div>

                                    </div>
                                </div>
                            @if($loan->payment_mode=='CHECK' && $loan->loan_to=='COMPANY')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="loan_to_bank_id">Bank Name: {{$loan->checkRegistryLoanTo->bank->name}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="loan_to_branch_id">Branch Name: {{$loan->checkRegistryLoanTo->branch->name}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="loan_to_bank_account_id">A/C Number: {{$loan->checkRegistryLoanTo->bankAccount->account_number}}</label>
                                            </div>
                                        </div>
                                    </div>

                            @endif
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        @if($loan->payment_mode=='CHECK' && $loan->loan_to=='COMPANY' && $loan->loan_from!='COMPANY')

                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="check_number">Check Number: {{$loan->checkRegistryLoanTo->check_number}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="check_number">Check Date: {{ date('d-m-Y', strtotime($loan->checkRegistryLoanTo->check_date))}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="check_number">Check Type: {{$loan->checkRegistryLoanTo->check_type}}</label>
                                </div>
                            </div>
                        @elseif($loan->payment_mode=='CHECK' && $loan->loan_to!='COMPANY' && $loan->loan_from=='COMPANY')
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="check_number">Check Number: {{$loan->checkRegistryLoanFrom->check_number}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="check_number">Check Date: {{ date('d-m-Y', strtotime($loan->checkRegistryLoanFrom->check_date))}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="check_number">Check Type: {{$loan->checkRegistryLoanFrom->check_type}}</label>
                                </div>
                            </div>
                        @elseif($loan->payment_mode=='CHECK' && $loan->loan_to=='COMPANY' && $loan->loan_from=='COMPANY')
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="check_number">Check Number: {{$loan->checkRegistryLoanTo->check_number}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="check_number">Check Date: {{ date('d-m-Y', strtotime($loan->checkRegistryLoanTo->check_date))}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="check_number">Check Type: {{$loan->checkRegistryLoanTo->check_type}}</label>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <div class="row">
                                <label class="col-md-12 col-form-label" for="check_number">Amount: {{number_format($loan->amount,'0','.',',')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>In words: <span class="to_word">
                                        @php use App\CustomClass\NumberToWordConverter;
                                        $amount = NumberToWordConverter::convert($loan->amount);
                                        @endphp
                                    {{$amount}}
                                    </span></h4>
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
            border: 1px solid #000;
        }
        legend {
            display: block;
            width: auto;
            max-width: 100%;
            padding: 0px 10px;
            margin-bottom: .5rem;
            font-size: 1.5rem;
            line-height: inherit;
            color: inherit;
            white-space: normal;
            border: 1px solid #000;
            border-radius: 10px;
        }
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
            border: none;
            color: #fff;
            -webkit-box-shadow: 0 -3px 10px 0 rgba(0, 0, 0, 0.05);
            box-shadow: 0 -3px 10px 0 rgba(0, 0, 0, 0.05);
            background-color: blue;
        }
    </style>
</div>
