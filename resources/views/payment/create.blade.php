@extends('layout')
@section('title','Add Payment')
@section('template')

<div class="col-sm-12">
 <div class="row">
   <div class="col-sm-12">
      <div class="card">
          <div class="card-header">
              <h5>Add Payment</h5>
              <div class="card-header-right">
                  <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                      <a href="{{route('payment')}}" class="btn btn-sm  btn-info"><i class="fas fa-angle-double-left"></i> Back</a>
                  </div>
              </div>
          </div>

          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif


          <div class="card-body">

              <form class="form-horizontal" action="{{ route('payment_store')}}" method="post" enctype="multipart/form-data">
                 {{ csrf_field() }}

                  <input type="hidden" class="session_transfer_amount" name="session_transfer_amount" value="{{session()->get('transfer_amount')}}">

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1"><h4>Create: Advance Payment</h4></label>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group" style="text-align: right">
                              <label for="exampleInputEmail1"><h4>Date: {{ date('d-m-Y') }}</h4></label>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-5">

                          <div class="form-group">
                              <label for="exampleInputEmail1">Paid To:</label>
                              <select style="{{$paymentUser?'pointer-events: none; background-color: #e7e7e7;':''}}" class="form-control select2" name="user_id" id="user_id" required>

                                  <option value="">Select User</option>
                                  @if($users)
                                      @foreach($users as $user)
                                          <option value="{{$user->id}}" {{$paymentUser==$user->id?'selected="selected"':''}}> {{$user->UserProfile['fname'].' '.$user->UserProfile['lname'] }} </option>
                                      @endforeach
                                  @endif
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1">Company:</label>
                              <select style="{{$paymentCompany?'pointer-events: none; background-color: #e7e7e7;':''}}" class="form-control" name="company_id" id="payment_company_id" required>

                                  <option value="">Select Company</option>
                                  @foreach($companies as $company)
                                      <option value="{{$company->id}}" {{$paymentCompany==$company->id?'selected="selected"':''}}> {{$company->name}} </option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="col-md-7">
                          <div class="form-group">
                              <label for="comments">Comments:</label>
                              <textarea name="comments" rows="5" class="form-control"></textarea>
                          </div>
                      </div>
                  </div>


                  <table class="table table-bordered payment_details_table" style="margin-bottom: 0px">
                   <thead class="thead-dark">
                    <tr>
                        <th width="30%">Project</th>
                        <th width="40%">Item Name</th>
                        <th style="text-align: right;padding-right: 15px" width="20%">Amount</th>
                        <th style="text-align: right;padding-right: 15px" width="10%">Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td>
                              <select class="form-control user_project_list" name="project_id[]" required>
                                  <option value="">Select Project</option>
                              </select>
                          </td>
                          <td>
                              <input type="text" class="form-control item_name" name="item_name[]" id="item_name" placeholder="Item Name" required>
                          </td>
                          <td style="text-align: right">
                              <input style="text-align:right;" type="text" class="form-control paid_amount amount" name="paid_amount[]" id="paid_amount" placeholder="Amount" required>
                          </td>
                          <td style="text-align: right">
                              <button type="button" class="btn btn-danger hide">Delete</button>
                          </td>
                      </tr>

                      </tbody>
                      <tfoot>
                      <tr style="font-weight: bold; font-size: 20px">
                          <td colspan="2" align="right" style="padding-right: 20px">Total:</td>
                          <td colspan="" class="total_amount" align="right" style="padding: 10px 20px"></td>
                          <td></td>
                      </tr>
                      @if(session()->get('transfer_amount'))
                      <tr style="font-weight: bold; font-size: 20px">
                          <td colspan="2" align="right" style="padding-right: 20px">Retried Amount:</td>
                          <td align="right" style="padding: 10px 20px">{{session()->get('transfer_amount')}}</td>
                          <td></td>
                      </tr>
                      @endif
                      </tfoot>
                  </table>
                  <div class="row">
                      <div style="padding-right: 5px" class="col-md-12 col-form-label" align="right">
                          <button style="margin-right: 0" type="button" class="btn btn-info btn-sm add-row"><i class="fa fa-plus" aria-hidden="true"></i> Add Row</button>
                      </div>
                  </div>
                  <div class="line aligncenter" style="float: right">
                      <div class="form-group row">
                          <div style="padding-right: 3px" class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                              <button onclick="return confirm('Are you sure?')" style="margin-right: 0" type="submit" class="btn btn-info btn-lg" data-original-title="" title="">Next <i class="fas fa-angle-double-right"></i></button>
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
        $(document).ready(function(){
            jQuery("#user_id, #payment_company_id").on('change',function(e){
                var element = e.target;
                e.preventDefault();
                var user_id = jQuery('#user_id').val();
                var payment_company_id = jQuery('#payment_company_id').val();
                if(user_id<=0 || payment_company_id==''){
                    var dataOption='<option value="">Select Project</option>';
                    jQuery('.user_project_list').html(dataOption);
                    return false;
                }
                jQuery.ajax({
                    type:'GET',
                    dataType : 'json',
                    url:'/project/user/'+ user_id,
                    data:{
                        'company_id':payment_company_id
                    },
                    success:function(data){
                        var dataOption='<option value="">Select Project</option>';
                        jQuery.each(data, function(i, item) {
                            dataOption += '<option value="'+item.id+'">'+item.name+'</option>';
                        });

                        jQuery('.user_project_list').html(dataOption);
                    }
                });
            }).change();

            $(".add-row").on('click', function(){
                var table = $('.payment_details_table');
                var nrow = table.find('tr:eq(1)').clone();
                nrow.find('td').find('button').removeClass('hide');
                nrow.find("input[type=text]").val("");
                table.append(nrow);
            });

            // Find and remove selected table rows
            $('body').on('click','.btn', function(){
                $(this).closest("tr").remove();
            });

            $('.js-example-basic-single').select2();

            $('.total_amount').text(calculateSum());
            jQuery(document).on('keyup','.amount', function () {
                var session_transfer_amount = jQuery('.session_transfer_amount').val();
                if (session_transfer_amount>0){
                    if(session_transfer_amount<calculateSum()){
                        alert('Maximum amount limit crossed');
                        jQuery(this).val('');
                        $('.total_amount').text(calculateSum());
                        return false;
                    }
                }
                $('.total_amount').text(calculateSum());
            });

            $(document).on("keypress keyup blur", ".paid_amount", function (e) {
                $(this).val($(this).val().replace(/[^0-9\.]/g,''));
                if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });
        });

        function calculateSum() {

            var sum = 0;
//iterate through each td based on class and add the values
            $(".amount").each(function() {

                //add only if the value is number
                if(!isNaN(this.value) && this.value.length!=0) {
                    sum += parseFloat(this.value);
                }

            });
            return sum;
        }

    </script>

@endsection



