@extends('layout')
@section('title','Income List')
@section('template')


    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Income Details Report </h5>

                    </div>
                    <div class="card-body">
                        <table class= "table table-bordered income_table">
                            <thead class="thead-dark">
                            <tr role="row" class="filter">

                                <td colspan="5">
                                    <select class="form-control" name="company_id" id="company_id" aria-describedby="validationTooltipPackagePrepend" required>
                                        <option value="">All Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td colspan="3">
                                    <select class="form-control project_id select2" name="project_id" id="project_id">
                                        <option value="">All Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->p_name }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td colspan="2">
                                    From <input style="display: inline; width: auto;"  type="date" data-date="" data-date-format="DD-MM-YYYY" value="" class="form-control date_picker" name="from_date" id="from_date">
                                </td>
                                <td colspan="2">
                                    To <input style="display: inline; width: auto;" type="date" data-date="" data-date-format="DD-MM-YYYY" value="" class="form-control date_picker" name="to_date" id="to_date">
                                </td>
                            </tr>

                            <tr>
                                <th style="width: 5%">SL</th>
                                <th>Date</th>

                                <th>Invoice No.</th>

                                {{--<th>Company Name.</th>--}}
                                <th>sorting date</th>
                                <th>Bill Am.</th>
                                <th>Certif. Am.</th>
                                <th>S/D Am.</th>
                                <th>I/T Am.</th>
                                <th>VAT</th>
                                <th>Others</th>
                                <th>Cheq. Am.</th>
                                <th>Cheque Referance</th>
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
    <!-- Modal -->
    <div class="modal fade" id="myModalIncome" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: block">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Income Details</h4>
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
    <script src="{{ asset("assets/datatable/income-detail-report.js") }}" ></script>

    <script type="text/javascript">
        jQuery(document).ready(function(){

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
                        console.log(data);
                        var dataOption='<option value>All Project</option>';
                        jQuery.each(data, function(i, item) {
                            dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                        });
                        jQuery('#project_id').html(dataOption);
                    }
                });

            });

            jQuery("#myModalIncome").on("show.bs.modal", function(e) {
                var id = jQuery(e.relatedTarget).data('target-income-id');
                jQuery.get( "/income/quick/view/" + id, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });

        });
    </script>
@endsection