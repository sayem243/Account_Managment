@extends('layout')
@section('title','Income Details')
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
                    {{--Advance Payment Information--}}

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Company Name : {{$income->company->name}}
                                    </label>
                                </div>
                            </div>

                        </div>
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

@endsection
