<form class="form-horizontal" action="{{ route('check_loan_store')}}" method="post"
      enctype="multipart/form-data">
    {{ csrf_field() }}
    {{--error showing --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <fieldset>
                <legend>From Information</legend>

                <div class="row">
                    <input type="hidden" name="transaction_type" value="LOAN_CHECK">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="check_loan_from" class="col-form-label">From <span
                                        class="required">*</span></label>
                            <div class="col-form-label">
                                <select id="check_loan_from" name="loan_from" class="form-control check_loan_from" required>
                                    <option value="USER">User</option>
                                    <option value="COMPANY">Company</option>
                                    {{--<option value="PROJECT">Project</option>--}}
                                    <option value="OTHERS">Others</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="check_loan_user_section">
                            <div class="form-group">
                                <label for="loan_from_value_user" class="col-form-label">User <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <select id="loan_from_value_user" name="loan_from_value_user" class="form-control select2">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="check_loan_company_section" style="display: none">
                            <div class="form-group">
                                <label for="loan_from_value_company" class="col-form-label">Company <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <select id="loan_from_value_company" name="loan_from_value_company" class="form-control loan_from_value_company">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company['id']}}">{{$company['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        {{--<div class="check_loan_project_section" style="display: none">
                            <div class="form-group">
                                <label for="loan_from_value_project" class="col-form-label">Project <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <select id="loan_from_value_project" name="loan_from_value_project" class="form-control loan_from_value_project">
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project['id']}}">{{$project['p_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>--}}
                        <div class="check_loan_other_section" style="display: none">
                            <div class="form-group">
                                <label for="loan_from_value_other" class="col-form-label">Provider Name <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <input id="loan_from_value_other" type="text" name="loan_from_value_other" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label" for="bank_id">Bank Name</label>
                            <div class="col-form-label">
                                <select class="form-control bank_id" name="loan_from_bank_id" id="bank_id">
                                    <option value="">Select Bank</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label" for="branch_id">Branch Name</label>
                            <div class="col-form-label">
                                <select id="branch_id" name="loan_from_branch_id" class="form-control branch_id">
                                    <option value="">Select Branch</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label" for="bank_account_id">Bank Account</label>
                            <div class="col-form-label">
                                <select id="bank_account_id" name="loan_from_bank_account_id" class="form-control bank_account_id">
                                    <option value="">Select Account</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend>To Information</legend>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loan_to" class="col-form-label">To <span
                                        class="required">*</span></label>
                            <div class="col-form-label">
                                <select id="loan_to" name="loan_to" class="form-control loan_to" required>
                                    <option value="USER">User</option>
                                    <option value="COMPANY">Company</option>
                                    {{--<option value="PROJECT">Project</option>--}}
                                    <option value="OTHERS">Others</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="to_user_section">
                            <div class="form-group">
                                <label for="check_loan_to_value_user" class="col-form-label">User <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <select id="check_loan_to_value_user" name="loan_to_value_user" class="form-control select2 loan_to_value_user">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="to_company_section" style="display: none">
                            <div class="form-group">
                                <label for="loan_to_value_company" class="col-form-label">Company <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <select id="loan_to_value_company" name="loan_to_value_company" class="form-control loan_to_value_company">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company['id']}}">{{$company['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        {{--<div class="to_project_section" style="display: none">
                            <div class="form-group">
                                <label for="loan_to_value_project" class="col-form-label">Project <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <select id="loan_to_value_project" name="loan_to_value_project" class="form-control loan_to_value_project">
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project['id']}}">{{$project['p_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>--}}
                        <div class="to_other_section" style="display: none">
                            <div class="form-group">
                                <label for="loan_to_value_other" class="col-form-label">Provider Name <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <input id="loan_to_value_other" type="text" name="loan_to_value_other" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label" for="loan_to_bank_id">Bank Name</label>
                            <div class="col-form-label">
                                <select class="form-control loan_to_bank_id" name="loan_to_bank_id" id="loan_to_bank_id">
                                    <option value="">Select Bank</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label" for="loan_to_branch_id">Branch Name</label>
                            <div class="col-form-label">
                                <select id="loan_to_branch_id" name="loan_to_branch_id" class="form-control loan_to_branch_id">
                                    <option value="">Select Branch</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label" for="loan_to_bank_account_id">Bank Account</label>
                            <div class="col-form-label">
                                <select id="loan_to_bank_account_id" name="loan_to_bank_account_id" class="form-control loan_to_bank_account_id">
                                    <option value="">Select Account</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <fieldset style="margin-top: 10px">
                <legend>Cheque Information</legend>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label" for="check_number">Cheque Number <span
                                        class="required">*</span></label>
                            <div class="col-form-label">
                                <input type="text" class="form-control" id="check_number" name="check_number" placeholder="Enter check number...">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label" for="check_date">Cheque Date <span
                                        class="required">*</span></label>
                            <div class="col-form-label">
                                <input type="date" id="check_date" name="check_date" class="form-control">
                                <span>Note: date format( mm-dd-yyyy )</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label" for="check_type">Cheque Type <span
                                        class="required">*</span></label>
                            <div class="col-form-label">
                                <label class="radio-inline" style="margin-right: 15px">
                                    <input required type="radio" name="check_type" value="ACCOUNT_PAY" id="check_type_ac_pay"> A/C Pay Cheque
                                </label>
                                <label class="radio-inline">
                                    <input required checked type="radio" name="check_type" value="CASH" id="check_type_cash"> Cash Cheque
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="check_amount" class="col-form-label">Amount <span
                                        class="required">*</span></label>
                            <div class="col-form-label">
                                <input id="check_amount" type="text" name="check_amount" class="form-control check_amount">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label" for="check_description">Description </label>
                            <div class="col-form-label">
                                <textarea class="form-control" id="check_description" name="check_description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>


    {{--<div class="row">
        <div class="col-md-12">
            <h4>In words: <span class="to_word"></span></h4>
        </div>
    </div>--}}

    <div class="line aligncenter" style="float: right">
        <div class="form-group row">
            <div style="padding-right: 3px" class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                <button style="margin-right: 0" type="submit" class="btn btn-info">
                    <i class="feather icon-save"></i> Save
                </button>
            </div>
        </div>
    </div>

</form>