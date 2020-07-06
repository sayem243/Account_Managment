@extends('layout')
@section('title','Add Bank')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Bank Account</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-lg" role="group"
                                 aria-label="Button group with nested dropdown">
                                <a href="{{route('account_index')}}" class="btn btn-info"><i
                                            class="fa fa-angle-double-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('account_store')}}" method="post"
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
                                        <label class="col-form-label" for="account_name">Account Name<span
                                                    class="required">*</span></label>
                                        <div class="col-form-label">
                                            <input type="text" class="form-control" name="account_name" id="account_name" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="account_number">Account Number<span
                                                    class="required">*</span></label>
                                        <div class="col-form-label">
                                            <input type="text" class="form-control" name="account_number" id="account_number" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="company_id">Company Name</label>
                                        <div class="col-form-label">
                                            <select name="company_id" class="form-control company_id">
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
                                        <label class="col-form-label" for="account_type">Account Type<span
                                                    class="required">*</span></label>
                                        <div class="col-form-label">
                                            <select class="form-control account_type" name="account_type" id="account_type">
                                                <option value="CURRENT">Current Account</option>
                                                <option value="SAVINGS">Savings Account</option>
                                                <option value="SALARY">Salary Account</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="bank_id">Bank Name<span
                                                    class="required">*</span></label>
                                        <div class="col-form-label">
                                            <select class="form-control bank_id" name="bank_id" id="bank_id" required>
                                                <option value="">Select Bank</option>
                                                @foreach($banks as $bank)
                                                    <option value="{{$bank['id']}}">{{$bank['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="branch_id">Branch Name</label>
                                        <div class="col-form-label">
                                            <select id="branch_id" name="branch_id" class="form-control branch_id" required>
                                                <option value="">Select Branch</option>
                                            </select>
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
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('body').on('change','#bank_id', function () {
                var bankId= jQuery(this).val();
                if(bankId===0||bankId===''){
                    var dataOption='<option value="">Select Branch</option>';
                    jQuery('#branch_id').html(dataOption);
                    return false;
                }
                jQuery.ajax({
                    type:'GET',
                    dataType : 'json',
                    url:'{{ url("/ajax/bank") }}/'+bankId,
                    data:{},
                    success:function(data){
                        var dataOption='<option value="">Select Branch</option>';
                        jQuery.each(data, function(i, item) {
                            dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                        });
                        jQuery('#branch_id').html(dataOption);
                    }
                });

            });

        });
    </script>
@endsection
