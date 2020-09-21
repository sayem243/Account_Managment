<form class="form-horizontal" action="{{ route('cash_income_store')}}" method="post"
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
                <label class="col-form-label" for="cash_income_company_id">Company Name
                    <span class="required">*</span></label>
                <div class="col-form-label">
                    <select id="cash_income_company_id" name="cash_income_company_id" class="form-control cash_income_company_id" required>
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
                <label class="col-form-label" for="cash_income_project_id">Project Name <span
                            class="required">*</span>
                    </label>
                <div class="col-form-label">
                    <select id="cash_income_project_id" name="cash_income_project_id" class="form-control cash_income_project_id" required>
                        <option value="">Select Project</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="cash_income_from_to_type" class="col-form-label">From<span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <select id="cash_income_from_to_type" name="cash_income_from_to_type" class="form-control cash_income_from_to_type" required>
                        <option value="USER">User</option>
                        <option value="COMPANY">Company</option>
                        <option value="PROJECT">Project</option>
                        <option value="CLIENT">Client</option>
                        <option value="OTHERS">Others</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="cash_income_user_section">
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
            <div class="cash_income_company_section" style="display: none">
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
            <div class="cash_income_project_section" style="display: none">
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
            <div class="cash_income_client_section" style="display: none">
                <div class="form-group">
                    <label for="from_to_value_client" class="col-form-label">Client <span
                                class="required">*</span></label>
                    <div class="col-form-label">
                        <select id="from_to_value_client" name="from_to_value_client" class="form-control from_to_value_client">
                            <option value="">Select Client</option>
                            @foreach($clients as $client)
                                <option value="{{$client['id']}}">{{$client['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="cash_income_other_section" style="display: none">
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
                    <input id="check_amount" type="text" name="cash_amount" class="form-control check_amount">
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
