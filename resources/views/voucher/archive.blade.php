@extends('layout')
@section('title','Vouchers Archived List')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Vouchers List</h5>
                    </div>
                    <div class="card-body voucher_item_table payment_table" style="padding-top: 5px">
                        {{--<div class="dt-buttons btn-group">
                            <a style="min-width: 100px; border-radius: .3rem; font-size: 16px" href="{{route('voucher_index')}}" class="btn btn-secondary buttons-alert btn-info" title="All"><span>All</span></a>
                            <a style="min-width: 100px; border-radius: .3rem; font-size: 16px" href="{{route('voucher_archive_index')}}" class="btn btn-secondary buttons-alert btn-info" title="Created"><span>Archived</span></a>
                        </div>--}}

                        <table class="table table-striped table-bordered table-hover table-checkable" id="voucher_table">
                            <thead class="thead-dark">
                            <tr role="row" class="filter">
                                <td colspan="2">
                                    <input  type="text" class="form-control form-filter input-sm" name="voucher_id" id="voucher_id" placeholder="Voucher Id">
                                </td>
                                <td colspan="1">
                                    <select class="form-control" name="company_id" id="company_id" aria-describedby="validationTooltipPackagePrepend" required>
                                        <option value="">All Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="project_id" id="project_id">
                                        <option value="">All Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->p_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td colspan="1">
                                    From <input style="display: inline; width: auto;"  type="date" data-date="" data-date-format="DD-MM-YYYY" value="" class="form-control date_picker" name="from_date" id="from_date">
                                </td>
                                <td colspan="1">
                                    To <input style="display: inline; width: auto;" type="date" data-date="" data-date-format="DD-MM-YYYY" value="" class="form-control date_picker" name="to_date" id="to_date">
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 30px" scope="col">SL.</th>
                                <th style="width: 250px" scope="col">Expenses Type</th>
                                <th style="width: 150px" scope="col">Voucher Id</th>
                                <th style="width: 150px" width="" scope="col">Company</th>
                                <th style="width: 150px" width="" scope="col">Project</th>
                                <th style="width: 100px" width="" scope="col">Amount</th>
                                <th scope="col text-center"><i class="feather icon-settings"></i></th>
                            </tr>

                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: block">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Voucher Details</h4>
                </div>

                <div class="modal-body">

                </div>


            </div>
        </div>
    </div>
    <style>
        .modal-dialog {
            width: 75%;
            max-width: 75%;
            height: 100%;
            padding: 0;
        }

        .modal-content {
            height: auto;
            min-height: 90%;
            border-radius: 0;
        }
    </style>
@endsection

@section('footer.scripts')
    <script src="{{ asset("assets/datatable/voucher-archived.js") }}" ></script>
    <script type="text/javascript">
        $(document).ready(function (){
            jQuery('body').on('change','#company_id', function () {
                var companyId= jQuery(this).val();
                if(companyId===0||companyId===''){
                    companyId = 0
                }
                jQuery.ajax({
                    type:'GET',
                    dataType : 'json',
                    url:'{{ url("/ajax/project/company") }}/'+companyId,
                    data:{},
                    success:function(data){
                        var dataOption='<option value>All Project</option>';
                        jQuery.each(data, function(i, item) {
                            dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                        });
                        jQuery('#project_id').html(dataOption);
                    }
                });

            });

            jQuery("#myModal").on("show.bs.modal", function(e) {
                jQuery(".modal-body").html('');
                var id = jQuery(e.relatedTarget).data('target-id');
                jQuery.get( "/voucher/quick/view/" + id, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });

        });
    </script>
@endsection

