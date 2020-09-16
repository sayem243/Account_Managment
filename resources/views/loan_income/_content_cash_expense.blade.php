<form class="form-horizontal" action="{{ route('ajax_add_voucher_item')}}" method="post"
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
        <input type="hidden" name="item_add_without_ajax" value="1">
        <div class="col-md-12">
            <div class="form-group">
                <label for="check_amount" class="col-form-label">Item Name <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <input type="text" placeholder="Enter item name" autocomplete="off" class="form-control voucher_item_name" name="item_name" required>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="check_amount" class="col-form-label">Project <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <select class="form-control item_project_id" name="project_id" id="item_project_id" required>
                        <option value="">All Project</option>
                        @foreach($projects as $project)
                            <option value="{{$project['id']}}">{{$project['p_name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="check_amount" class="col-form-label">Amount <span
                            class="required">*</span></label>
                <div class="col-form-label">
                    <input type="text" placeholder="Enter amount" class="form-control only-number voucher_item_amount" name="voucher_amount" required>
                </div>
            </div>
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