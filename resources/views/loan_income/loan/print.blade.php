@extends('admin.index-pdf')
@section('title','loan_voucher_'.time())
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body"
                         style="border: 1px solid #000; margin-bottom: 5px; position: relative; min-height: 430px; padding: 15px">
                        <h5 style="position: absolute; right: 25px; top: 15px">Cr. No. {{$loan->loan_generate_id}}</h5>
                        <h5 style="position: absolute; left: 25px; top: 15px">
                            Date: {{ date('d-m-Y', strtotime($loan->created_at))}}</h5>
                        <h5 style="text-align: center; margin-bottom: 5px;font-size: 20px">Loan Voucher</h5>
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
                        <div style="padding: 0 10px; clear: both">
                            <hr style="margin-top: 1px; margin-bottom: 10px; border-color: #000000">
                        </div>
                        <div class="row">
                            <table class="table" style="border: none">
                                <tr>
                                    <td style="border: none; vertical-align: top">
                                        <div class="col-md-4">
                                            <fieldset style="margin-bottom: 10px">
                                                <legend>Transaction Information</legend>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <label style="font-weight: bold; font-size: 18px"
                                                                   class="col-md-12 col-form-label" for="company_id">From :
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

                                                    @if($loan->payment_mode=='CHECK' && $loan->loan_to=='COMPANY' && $loan->loan_from!='COMPANY')

                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="check_number">Check
                                                                    Number: {{$loan->checkRegistryLoanTo->check_number}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="check_number">Check
                                                                    Date: {{ date('d-m-Y', strtotime($loan->checkRegistryLoanTo->check_date))}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="check_number">Transaction
                                                                    Type: {{$loan->checkRegistryLoanTo->check_type}} {{$loan->payment_mode}}</label>
                                                            </div>
                                                        </div>
                                                    @elseif($loan->payment_mode=='CHECK' && $loan->loan_to!='COMPANY' && $loan->loan_from=='COMPANY')
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="check_number">Check
                                                                    Number: {{$loan->checkRegistryLoanFrom->check_number}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="check_number">Check
                                                                    Date: {{ date('d-m-Y', strtotime($loan->checkRegistryLoanFrom->check_date))}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="check_number">Transaction
                                                                    Type: {{$loan->checkRegistryLoanFrom->check_type}} {{$loan->payment_mode}}</label>
                                                            </div>
                                                        </div>
                                                    @elseif($loan->payment_mode=='CHECK' && $loan->loan_to=='COMPANY' && $loan->loan_from=='COMPANY')
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="check_number">Check
                                                                    Number: {{$loan->checkRegistryLoanTo->check_number}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="check_number">Check
                                                                    Date: {{ date('d-m-Y', strtotime($loan->checkRegistryLoanTo->check_date))}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="check_number">Transaction
                                                                    Type: {{$loan->checkRegistryLoanTo->check_type}} {{$loan->payment_mode}}</label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($loan->payment_mode=='CASH')
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="check_number">Transaction
                                                                    Type: {{$loan->payment_mode}}</label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>


                                            </fieldset>
                                        </div>
                                    </td>
                                    <td style="border: none; vertical-align: top">
                                        @if($loan->payment_mode=='CHECK' && $loan->loan_from=='COMPANY')
                                            <div class="col-md-4">
                                                <fieldset style="margin-bottom: 10px">
                                                    <legend>Check Information</legend>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="loan_to_bank_id">Bank
                                                                    Name: {{$loan->checkRegistryLoanFrom->bank->name}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="loan_to_branch_id">Branch
                                                                    Name: {{$loan->checkRegistryLoanFrom->branch->name}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label"
                                                                       for="loan_to_bank_account_id">A/C
                                                                    Number: {{$loan->checkRegistryLoanFrom->bankAccount->account_number}}</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </fieldset>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="border: none; vertical-align: top">
                                        @if($loan->payment_mode=='CHECK' && $loan->loan_to=='COMPANY')
                                            <div class="col-md-4">
                                                <fieldset>
                                                    <legend>Deposit Information</legend>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="loan_to_bank_id">Bank
                                                                    Name: {{$loan->checkRegistryLoanTo->bank->name}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label" for="loan_to_branch_id">Branch
                                                                    Name: {{$loan->checkRegistryLoanTo->branch->name}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <label class="col-md-12 col-form-label"
                                                                       for="loan_to_bank_account_id">A/C
                                                                    Number: {{$loan->checkRegistryLoanTo->bankAccount->account_number}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        @endif
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
                                            <label style="font-size: 18px; font-weight: bold" class="col-md-12 col-form-label"
                                                   for="check_number">Amount: {{number_format($loan->amount,'0','.',',')}}</label>
                                        </fieldset>
                                    </td>
                                    <td style="border: none">
                                        <fieldset>
                                            <label class="col-md-12 col-form-label"
                                                   for="check_number">Description: {{$loan->description}}</label>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: none" colspan="2">
                                        <fieldset>
                                            <label style="font-weight: bold; font-size: 20px" class="col-md-12 col-form-label">In
                                                words: <span class="to_word">
                                    @php use App\CustomClass\NumberToWordConverter;
                                    $amount = NumberToWordConverter::convert($loan->amount);
                                    @endphp
                                                    {{$amount}}
                                    </span>
                                            </label>
                                        </fieldset>
                                    </td>
                                </tr>
                            </table>
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
