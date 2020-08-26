@extends('layout')
@section('title','Edit Bank')
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
                        <form class="form-horizontal" action="{{ route('account_update',$account->id)}}" method="post"
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
                                            <input type="text" class="form-control" name="account_name" id="account_name" required="" value="{{$account->account_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="account_number">Account Number<span
                                                    class="required">*</span></label>
                                        <div class="col-form-label">
                                            <input type="text" class="form-control" name="account_number" id="account_number" required="" value="{{$account->account_number}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="company_id">Company Name<span
                                                    class="required">*</span></label>
                                        <div class="col-form-label">
                                            <select name="company_id" class="form-control company_id" required>
                                                <option value="">Select Company</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company['id']}}" {{$account->company_id==$company['id']?'selected="selected"':''}}>{{$company['name']}}</option>
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
                                                <option value="CURRENT" {{$account->account_type=='CURRENT'?'selected="selected"':''}}>Current Account</option>
                                                <option value="SAVINGS" {{$account->account_type=='SAVINGS'?'selected="selected"':''}}>Savings Account</option>
                                                <option value="SALARY" {{$account->account_type=='SALARY'?'selected="selected"':''}}>Salary Account</option>
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
                                                    <option value="{{$bank['id']}}" {{$account->bank_id==$bank['id']?'selected="selected"':''}}>{{$bank['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="branch_id">Branch Name</label>
                                        <div class="col-form-label">
                                            <input type="hidden" value="{{$account->branch_id}}" class="selected_branch_id">
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
            jQuery('#bank_id').on('change', function () {
                var bankId= jQuery(this).val();
                var branchId= jQuery('.selected_branch_id').val();
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
                        var selectedItem='';

                        var dataOption='<option value="">Select Branch</option>';
                        jQuery.each(data, function(i, item) {
                            if(item.id==branchId){
                                selectedItem='selected="selected"';
                            }
                            dataOption += '<option value="'+item.id+'" '+selectedItem+'>'+item.name+'</option>';
                        });
                        jQuery('#branch_id').html(dataOption);
                    }
                });

            }).change();

        });
    </script>
@endsection
