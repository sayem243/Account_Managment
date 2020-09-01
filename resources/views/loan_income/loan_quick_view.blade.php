
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                {{--Advance Payment Information--}}

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 style="text-align: center">ID : {{$loan->loan_generate_id}}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4 style="text-align: right">Date: {{ date('d-m-Y', strtotime($loan->created_at))}}</h4>
                        </div>
                    </div>
                    <fieldset style="margin-bottom: 10px">
                        <legend>From Information</legend>

                        <div class="row">
                            <div class="col-md-3">
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

                        @if($loan->payment_mode=='CHECK')

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
                                        <label class="col-md-12 col-form-label" for="loan_to_bank_account_id">Bank Account Number: {{$loan->checkRegistryLoanFrom->bankAccount->account_number}}</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </fieldset>

                    <fieldset>
                        <legend>To Information</legend>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="company_id">To :
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

                        @if($loan->payment_mode=='CHECK')

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
                                        <label class="col-md-12 col-form-label" for="loan_to_bank_account_id">Bank Account Number: {{$loan->checkRegistryLoanTo->bankAccount->account_number}}</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                    </fieldset>
                    <div class="row">
                        @if($loan->payment_mode=='CHECK')

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
