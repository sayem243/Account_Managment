@extends('layout')
@section('title','Income List')
@section('template')


 <div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
       <div class="card">
          <div class="card-header">
              <h5>Income List </h5>
              <div class="card-header-right">
                  @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('loan-income-create'))
                  <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested">
                      <a href="{{route('loan_income_create',['type'=>'income'])}}" class="btn btn-sm  btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
                  </div>
                  @endif
              </div>

                </div>
      <div class="card-body">
         <table class= "table table-bordered income_table">
             <thead class="thead-dark">
                 <tr>
                     <td style="border: none" colspan="9">
                         <table class="table" style="margin-bottom: 0;">
                             <tr role="row" class="filter">
                                 <td colspan="2">
                                     <input  type="text" class="form-control form-filter input-sm income_generate_id" name="income_generate_id" id="income_generate_id" placeholder="Income Voucher Id">
                                 </td>

                                 <td colspan="2">
                                     <select class="form-control" name="company_id" id="company_id" aria-describedby="validationTooltipPackagePrepend" required>
                                         <option value="">All Company</option>
                                         @foreach($companies as $company)
                                             <option value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                                         @endforeach
                                     </select>
                                 </td>
                                 <td colspan="1">
                                     <select class="form-control project_id select2" name="project_id" id="project_id">
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
                         </table>
                     </td>
                 </tr>
                 <tr>
                     <th style="width: 5%">SL</th>
                     <th>Number</th>
                     <th>Cheque Date</th>
                     <th>Created Date</th>
                     <th>Type</th>
                     <th>Company</th>
                     <th>From</th>
                     <th>Amount</th>
                     <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 5%;">
                            <i class="feather icon-settings"></i>
                   </th>
               </tr>
             </thead>
                <tbody>

                </tbody>
             <tfoot>
             <tr>
                 <th colspan="7" style="text-align:right">Total:</th>
                 <th colspan="2"></th>
             </tr>
             </tfoot>
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
    <script src="{{ asset("assets/datatable/income-datatable.js") }}" ></script>

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