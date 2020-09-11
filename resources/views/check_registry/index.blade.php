@extends('layout')
@section('title','Check Registry List')
@section('template')


 <div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
       <div class="card">
          <div class="card-header">
              <h5>Check Registry </h5>
              {{--<div class="card-header-right">
                  @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('superadmin') || auth()->user()->can('check-registry-create'))
                  <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested">
                      <a href="{{route('check_registry_create')}}" class="btn btn-sm  btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
                  </div>
                  @endif
              </div>--}}

          </div>

           <div class="card-body">
         <table class= "table table-bordered check_registry display">
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
                   <th>Company</th>
                   <th>Amount</th>
                   <th>Check Type</th>
                   <th>Type</th>
                   <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 5%;">
                            <i class="feather icon-settings"></i>
                   </th>
               </tr>
             </thead>
                <tbody>

                </tbody>
             <tfoot>
             <tr>
                 <th colspan="4" style="text-align:right">Total:</th>
                 <th colspan="4"></th>
             </tr>
             </tfoot>

            </table>

                </div>





        </div>
    </div>

    </div>
    </div>
 <!-- Modal -->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header" style="display: block">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                 <h4 class="modal-title" id="myModalLabel">Check Registry Details</h4>
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
    <script src="{{ asset("assets/datatable/check-registry.js") }}" ></script>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#myModal").on("show.bs.modal", function(e) {
                var id = jQuery(e.relatedTarget).data('target-id');
                jQuery.get( "/check/registry/quick/view/" + id, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });

        });
    </script>
@endsection