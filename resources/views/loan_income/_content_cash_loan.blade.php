<form class="form-horizontal" action="{{ route('cash_loan_store')}}" method="post"
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cash_loan_from" class="col-form-label">From <span
                                        class="required">*</span></label>
                            <div class="col-form-label">
                                <select id="cash_loan_from" name="cash_loan_from" class="form-control cash_loan_from" required>
                                    <option value="USER">User</option>
                                    <option value="COMPANY">Company</option>
                                    {{--<option value="PROJECT">Project</option>--}}
                                    <option value="OTHERS">Others</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="cash_loan_user_section">
                            <div class="form-group">
                                <label for="cash_loan_from_value_user" class="col-form-label">User <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <select id="cash_loan_from_value_user" name="loan_from_value_user" class="form-control select2 cash_loan_from_value_user">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="cash_loan_company_section" style="display: none">
                            <div class="form-group">
                                <label for="cash_loan_from_value_company" class="col-form-label">Company <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <select id="cash_loan_from_value_company" name="loan_from_value_company" class="form-control cash_loan_from_value_company">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company['id']}}">{{$company['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        {{--<div class="cash_loan_project_section" style="display: none">
                            <div class="form-group">
                                <label for="cash_loan_from_value_project" class="col-form-label">Project <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <select id="cash_loan_from_value_project" name="loan_from_value_project" class="form-control cash_loan_from_value_project">
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project['id']}}">{{$project['p_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>--}}
                        <div class="cash_loan_other_section" style="display: none">
                            <div class="form-group">
                                <label for="cash_loan_from_value_other" class="col-form-label">Provider Name <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <input id="cash_loan_from_value_other" type="text" name="loan_from_value_other" class="form-control cash_loan_from_value_other">
                                </div>
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
                            <label for="cash_loan_to" class="col-form-label">To <span
                                        class="required">*</span></label>
                            <div class="col-form-label">
                                <select id="cash_loan_to" name="cash_loan_to" class="form-control cash_loan_to" required>
                                    <option value="USER">User</option>
                                    <option value="COMPANY">Company</option>
                                    {{--<option value="PROJECT">Project</option>--}}
                                    <option value="OTHERS">Others</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cash_loan_to_user_section">
                            <div class="form-group">
                                <label for="loan_to_value_user" class="col-form-label">User <span
                                            class="required">*</span></label>
                                <div class="col-form-label">
                                    <select id="loan_to_value_user" name="loan_to_value_user" class="form-control select2">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="cash_loan_to_company_section" style="display: none">
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
                        {{--<div class="cash_loan_to_project_section" style="display: none">
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
                        <div class="cash_loan_to_other_section" style="display: none">
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

            </fieldset>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <fieldset style="margin-top: 10px">
                <legend>Amount Information</legend>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="check_amount" class="col-form-label">Amount <span
                                        class="required">*</span></label>
                            <div class="col-form-label">
                                <input id="check_amount" type="text" name="cash_amount" class="form-control check_amount">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
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
            <div style="padding-right: 3px"
                 class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                <button style="margin-right: 0" type="submit" class="btn btn-info"><i
                            class="feather icon-save"></i> Save
                </button>
            </div>
        </div>
    </div>

</form>