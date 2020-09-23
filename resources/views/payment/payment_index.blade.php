@extends('layout')
@section('title','Advance Payment')
@section('template')
    <style>
        /*input.date_picker {
            position: relative;
            height: 35px;
            color: white;
        }

        input.date_picker:before {
            position: absolute;
            top: 5px; left: 5px;
            content: attr(data-date);
            display: inline-block;
            color: black;
        }

        input.date_picker::-webkit-datetime-edit, input.date_picker::-webkit-inner-spin-button, input.date_picker::-webkit-clear-button {
            display: none;
        }

        input.date_picker::-webkit-calendar-picker-indicator {
            position: absolute;
            top: 5px;
            right: 0;
            color: black;
            opacity: 1;
        }*/

    </style>

 <div class="col-sm-12">
   <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
         <h5>Advance Payment</h5>
            <div class="card-header-right">
                @if(auth()->user()->can('Payment-create'))
                    <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                        <a style="-webkit-transform: scale(0.9);" href="{{route('payment_create')}}" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
                    </div>
                @endif

            </div>

        </div>
          <div class="card-body payment_table">

              {{--{!! $payments->links() !!}--}}
              <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                  <thead class="thead-dark">
                  <tr role="row" class="filter">
                      <td colspan="5"></td>
                      <td colspan="4">
                          <input type="text" id="item_search" class="form-control item_search" placeholder="Search item name ....">
                      </td>
                  </tr>
                  <tr role="row" class="filter">
                      <td colspan="2">
                          <input  type="text" class="form-control form-filter input-sm" name="payment_id" id="payment_id" placeholder="Payment Id">
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
                          <select class="form-control select2" name="project_id" id="project_id">
                              <option value="">All Project</option>
                              @foreach($projects as $project)
                                  <option value="{{ $project->id }}">{{ $project->p_name }}</option>
                              @endforeach
                          </select>
                      </td>


                      <td colspan="1">
                          <select class="form-control select2" name="user_id" id="user_id" >
                              <option value="">All User</option>
                              @foreach($users as $user)
                                  <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                              @endforeach
                          </select>
                      </td>
                      <td colspan="1">
                          From <input style="display: inline; width: auto;"  type="date" data-date="" data-date-format="DD-MM-YYYY" value="" class="form-control date_picker" name="from_date" id="from_date">
                      </td>
                      <td colspan="2">
                          To <input style="display: inline; width: auto;" type="date" data-date="" data-date-format="DD-MM-YYYY" value="" class="form-control date_picker" name="to_date" id="to_date">
                      </td>
                  </tr>
                  <tr>
                      <th scope="col">S/N</th>
                      <th width="80px" scope="col">Date</th>
                      <th width="100px" scope="col">HS ID</th>
                      <th width="150px" scope="col">Name</th>
                      <th width="150px" scope="col">Company</th>
                      <th width="200px" scope="col">Amount</th>
                      <th width="150px" scope="col">Status</th>
                      <th width="170px" scope="col text-center">Action</th>
                      <th scope="col text-center"><i class="feather icon-settings"></i></th>
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
                 <h4 class="modal-title" id="myModalLabel">Payment Details</h4>
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
         height: 100%;
         padding: 0;
     }

     .modal-content {
         height: auto;
         min-height: 100%;
         border-radius: 0;
     }
 </style>
@endsection

@section('footer.scripts')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>--}}
    <script src="{{ asset("assets/datatable/payment.js") }}" ></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            // project by company
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

            // user by project
            jQuery('body').on('change','#project_id', function () {
                var projectId= jQuery(this).val();
                if(projectId===0||projectId===''){
                    projectId = 0
                }
                jQuery.ajax({
                    type:'GET',
                    dataType : 'json',
                    url:'{{ url("/ajax/user/project") }}/'+projectId,
                    data:{},
                    success:function(data){
                        console.log(data);
                        var dataOption='<option value>All User</option>';
                        jQuery.each(data, function(i, item) {
                            dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                        });
                        jQuery('#user_id').html(dataOption);
                    }
                });

            });

            jQuery("#myModal").on("show.bs.modal", function(e) {
                var id = jQuery(e.relatedTarget).data('target-id');
                jQuery.get( "/payment/quick/view/" + id, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });

            /*$("input[type=date]").on("change", function() {
                this.setAttribute(
                    "data-date",
                    moment(this.value, "YYYY-MM-DD")
                        .format( this.getAttribute("data-date-format") )
                )
            }).trigger("change")*/
        });
    </script>
@endsection
