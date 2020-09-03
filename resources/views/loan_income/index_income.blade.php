@extends('layout')
@section('title','Loan List')
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
                      <a href="{{route('loan_income_create')}}" class="btn btn-sm  btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
                  </div>
                  @endif
              </div>

                </div>
      <div class="card-body">
         <table class= "table table-bordered income_table">
             <thead class="thead-dark">
                 <tr role="row" class="filter">
                     <td colspan="2">
                         <input  type="text" class="form-control form-filter input-sm" name="check_number" id="check_number" placeholder="Check Number....">
                     </td>

                     <td colspan="2">
                         <select class="form-control" name="company_id" id="company_id" aria-describedby="validationTooltipPackagePrepend" required>
                             <option value="">All Company</option>
                             @foreach($companies as $company)
                                 <option value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                             @endforeach
                         </select>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                 </tr>
                 <tr>
                     <th style="width: 5%">SL</th>
                     <th>Number</th>
                     <th>Check Date</th>
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
         width: 95%;
         max-width: 95%;
         height: 95%;
         padding: 0;
     }

     .modal-content {
         height: auto;
         min-height: 95%;
         border-radius: 0;
     }
 </style>
@endsection
@section('footer.scripts')
    <script src="{{ asset("assets/datatable/income-datatable.js") }}" ></script>

    <script type="text/javascript">
        jQuery(document).ready(function(){

            jQuery("#myModalIncome").on("show.bs.modal", function(e) {
                var id = jQuery(e.relatedTarget).data('target-income-id');
                jQuery.get( "/income/quick/view/" + id, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });

        });
    </script>
@endsection