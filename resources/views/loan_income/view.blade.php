@extends('layout')
@section('title','Details Check Registry')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Check Registry</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-lg" role="group"
                                 aria-label="Button group with nested dropdown">
                                <a href="{{route('check_registry_index')}}" class="btn btn-info"><i
                                            class="fa fa-angle-double-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Company Name : {{$checkRegistry->company->name}}
                                        </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Bank Name : {{$checkRegistry->bank->name}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Branch Name : {{$checkRegistry->branch->name}}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Bank Account : {{$checkRegistry->bankAccount->account_number}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Check Number : {{$checkRegistry->check_number}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Check Date : {{$checkRegistry->check_date}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Check Type : {{$checkRegistry->check_type}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Transaction Type : {{$checkRegistry->check_mode=='IN'?'Credit':'Debit'}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">From/To :
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
                                        @if($checkRegistry->from_to_type=='OTHERS')
                                            {{$checkRegistry->from_to_value}}
                                        @endif
                                    </label>
                                </div>

                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label" for="company_id">Amount : {{$checkRegistry->amount}}</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label" for="company_id">Description : {{$checkRegistry->description}}</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Write in words: <span class="to_word">
                                        @php use App\CustomClass\NumberToWordConverter;
                                        $amount = NumberToWordConverter::convert($checkRegistry->amount);
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

@endsection