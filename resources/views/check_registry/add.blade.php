@extends('layout')
@section('title','Add Bank')
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
                                        <label class="col-form-label" for="bank_id">Bank Name <span
                                                    class="required">*</span></label>
                                        <div class="col-form-label">
                                            <select class="form-control bank_id" name="bank_id" id="bank_id" required>
                                                <option value="">Select Bank</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="branch_id">Branch Name <span
                                                    class="required">*</span></label>
                                        <div class="col-form-label">
                                            <select id="branch_id" name="branch_id" class="form-control branch_id" required>
                                                <option value="">Select Branch</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="bank_account_id">Bank Account <span
                                                    class="required">*</span></label>
                                        <div class="col-form-label">
                                            <select id="bank_account_id" name="bank_account_id" class="form-control bank_account_id" required>
                                                <option value="">Select Account</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="check_type" class="form-check-input" value="A/C PAY" id="check_type">
                                        <label class="form-check-label" for="check_type">A/C Pay</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="check_mode" class="col-sm-6 col-form-label col-form-label-sm">Check Mode <span
                                                    class="required">*</span></label>
                                        <div class="col-sm-6">
                                            <select id="check_mode" name="check_mode" class="form-control check_mode" required>
                                                <option value="IN">IN</option>
                                                <option value="OUT">OUT</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="check_date" class="col-sm-4 col-form-label col-form-label-sm">Check Date <span
                                                    class="required">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="date" id="check_date" name="check_date" class="form-control">
                                            <span>Note: date format( mm-dd-yyyy )</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="check_number" placeholder="Enter check number...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="from_to_type" class="col-sm-4 col-form-label col-form-label-sm">From/To <span
                                                    class="required">*</span></label>
                                        <div class="col-sm-6">
                                            <select id="from_to_type" name="from_to_type" class="form-control from_to_type" required>
                                                <option value="USER">User</option>
                                                <option value="COMPANY">Company</option>
                                                <option value="PROJECT">Project</option>
                                                <option value="OTHERS">Others</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="user_section">
                                        <div class="form-group row">
                                            <label for="from_to_value_user" class="col-sm-3 col-form-label col-form-label-sm">User <span
                                                        class="required">*</span></label>
                                            <div class="col-sm-8">
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
                                        <div class="form-group row">
                                            <label for="from_to_value_company" class="col-sm-4 col-form-label col-form-label-sm">Company <span
                                                        class="required">*</span></label>
                                            <div class="col-sm-8">
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
                                        <div class="form-group row">
                                            <label for="from_to_value_project" class="col-sm-3 col-form-label col-form-label-sm">Project <span
                                                        class="required">*</span></label>
                                            <div class="col-sm-8">
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
                                        <div class="form-group row">
                                            <label for="from_to_value_other" class="col-sm-3 col-form-label col-form-label-sm">Provider Name <span
                                                        class="required">*</span></label>
                                            <div class="col-sm-8">
                                                <input id="from_to_value_other" type="text" name="from_to_value_other" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="check_amount" class="col-sm-4 col-form-label col-form-label-sm">Amount <span
                                                    class="required">*</span></label>
                                        <div class="col-sm-8">
                                            <input id="check_amount" type="text" name="check_amount" class="form-control check_amount">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Write in words: <span class="to_word"></span></h4>
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

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer.scripts')
    <script src="{{ asset("assets/js/check-registry.js") }}" ></script>
@endsection
