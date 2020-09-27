@extends('layout')
@section('title','Cheque Registry List')
@section('template')


 <div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
       <div class="card">
          <div class="card-header">
              <h5>Cheque Registry </h5>
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
                     <td colspan="9">
                         <table class="table" style="margin-bottom: 0">
                             <tr>
                                 <td colspan="2">
                                     <input  type="text" class="form-control form-filter input-sm" name="check_number" id="check_number" placeholder="Cheque Number....">
                                 </td>

                                 <td colspan="1">
                                     <select class="form-control company_id" name="company_id" id="company_id">
                                         <option value="">All Company</option>
                                         @foreach($companies as $company)
                                             <option value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                                         @endforeach
                                     </select>
                                 </td>
                                 <td>
                                     <select class="form-control bank_id" name="bank_id" id="bank_id">
                                         <option value="">All Bank</option>
                                         @foreach($banks as $bank)
                                             <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                         @endforeach
                                     </select>
                                 </td>
                                 <td>
                                     <select class="form-control branch_id" name="branch_id" id="branch_id">
                                         <option value="">All Branch</option>
                                         @foreach($branches as $branch)
                                             <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                         @endforeach
                                     </select>
                                 </td>
                                 <td>
                                     <select class="form-control bank_account_id select2" name="bank_account_id" id="bank_account_id">
                                         <option value="">All Account</option>
                                         @foreach($bankAccounts as $bankAccount)
                                             <option value="{{ $bankAccount->id }}">{{ $bankAccount->account_number }}</option>
                                         @endforeach
                                     </select>
                                 </td>
                                 <td colspan="2">
                                     From <input style="display: inline; width: auto;"  type="date" data-date="" data-date-format="DD-MM-YYYY" value="" class="form-control date_picker" name="from_date" id="from_date">
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
                   <th>Company</th>
                   <th>Amount</th>
                   <th>Cheque Type</th>
                   <th>Type</th>
                   <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 20px">
                            <i class="feather icon-settings"></i>
                   </th>
               </tr>
             </thead>
                <tbody>

                </tbody>
             <tfoot>
             <tr>
                 <th colspan="5" style="text-align:right">Total:</th>
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
                 <h4 class="modal-title" id="myModalLabel">Cheque Registry Details</h4>
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
    <script src="{{ asset("assets/js/check-registry.js") }}" ></script>
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