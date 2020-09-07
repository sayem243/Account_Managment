<form class="form-horizontal" action="{{ route('check_registry_store')}}" method="post"
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
            <div class="form-group">
                <label class="col-form-label" for="company_id">Company Name
                    <span class="required">*</span></label>
                <div class="col-form-label">
                    <select name="company_id" class="form-control company_id" required>
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{$company['id']}}">{{$company['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-form-label" for="check_expense_project_id">Project Name</label>
                <div class="col-form-label">
                    <select id="check_expense_project_id" name="project_id" class="form-control check_expense_project_id">
                        <option value="">Select Project</option>

                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label" for="expense_bank_id">Bank Name <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <select class="form-control expense_bank_id" name="bank_id" id="expense_bank_id" required>
                        <option value="">Select Bank</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label" for="expense_branch_id">Branch Name <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <select id="expense_branch_id" name="branch_id" class="form-control expense_branch_id" required>
                        <option value="">Select Branch</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label" for="expense_bank_account_id">Bank Account <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <select id="expense_bank_account_id" name="bank_account_id" class="form-control expense_bank_account_id" required>
                        <option value="">Select Account</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label" for="check_number">Check Number <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <input type="text" class="form-control" id="check_number" name="check_number" placeholder="Enter check number...">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label" for="check_date">Check Date <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <input type="date" id="check_date" name="check_date" class="form-control">
                    <span>Note: date format( mm-dd-yyyy )</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label" for="check_type">Check Type <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <label class="radio-inline" style="margin-right: 15px">
                        <input required type="radio" name="check_type" value="ACCOUNT_PAY" id="check_type_ac_pay"> A/C Pay Check
                    </label>
                    <label class="radio-inline">
                        <input required checked type="radio" name="check_type" value="CASH" id="check_type_cash"> Cash Check
                    </label>
                </div>
            </div>
        </div>

        <input type="hidden" id="check_mode" class="check_mode" name="check_mode" value="OUT">
        {{--<div class="col-md-3">
            <div class="form-group">
                <label class="col-form-label" for="check_mode">Transaction Type <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <select id="check_mode" name="check_mode" class="form-control check_mode" required>
                        <option value="OUT">Debit</option>
                    </select>
                </div>
            </div>
        </div>--}}
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="from_to_type" class="col-form-label">To <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <select id="from_to_type" name="from_to_type" class="form-control from_to_type" required>
                        <option value="USER">User</option>
                        <option value="COMPANY">Company</option>
                        <option value="PROJECT">Project</option>
                        <option value="OTHERS">Others</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="user_section">
                <div class="form-group">
                    <label for="from_to_value_user" class="col-form-label">User <span
                                class="required">*</span></label>
                    <div class="col-form-label">
                        <select id="from_to_value_user" name="from_to_value_user" class="form-control">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{$user['id']}}">{{$user['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="company_section" style="display: none">
                <div class="form-group">
                    <label for="from_to_value_company" class="col-form-label">Company <span
                                class="required">*</span></label>
                    <div class="col-form-label">
                        <select id="from_to_value_company" name="from_to_value_company" class="form-control">
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{$company['id']}}">{{$company['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="project_section" style="display: none">
                <div class="form-group">
                    <label for="from_to_value_project" class="col-form-label">Project <span
                                class="required">*</span></label>
                    <div class="col-form-label">
                        <select id="from_to_value_project" name="from_to_value_project" class="form-control from_to_value_project">
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                                <option value="{{$project['id']}}">{{$project['p_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="other_section" style="display: none">
                <div class="form-group">
                    <label for="from_to_value_other" class="col-form-label">Provider Name <span
                                class="required">*</span></label>
                    <div class="col-form-label">
                        <input id="from_to_value_other" type="text" name="from_to_value_other" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="check_amount" class="col-form-label">Amount <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <input id="check_amount" type="text" name="check_amount" class="form-control check_amount">
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="col-form-label" for="check_description">Description </label>
                    <div class="col-form-label">
                        <textarea class="form-control" id="check_description" name="check_description"></textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="line aligncenter" style="float: right">
        <div class="form-group row">
            <div style="padding-right: 3px"
                 class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                <button style="margin-right: 0" type="submit" class="btn btn-info"><i
                            class="feather icon-save"></i> Save
                </button>
            </div>
        </div>
    </div>

</form>
