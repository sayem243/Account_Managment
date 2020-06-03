@extends('admin.index')
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
                      <div class="col-md-6">

                          <div class="form-group">
                              <label for="exampleInputEmail1">Paid To:</label>
                              <select class="form-control js-example-basic-single" name="user_id" id="user_id" required>

                                  <option value="">Select User</option>
                                  @foreach($users as $user)
                                      <option value="{{$user->id}}"> {{$user->UserProfile['fname'].' '.$user->UserProfile['lname'] }} </option>
        {{--                              <td> {{$user->UserProfile['fname'].' '.$user->UserProfile['lname']}}</td>--}}
                                  @endforeach
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="comments">Comments:</label>
                              <textarea name="comments" rows="4" class="form-control"></textarea>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-12 col-form-label" align="right">
                      <input type="button" class="btn btn-info add-row" value="Add Row">
                  </div>

                  <table class="table table-bordered payment_details_table">
                   <thead class="thead-dark">
                    <tr>
                        <th>Project</th>
                        <th>Item Name</th>
                        <th>Amount</th>
                        <th>Action</th>
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
                          <td>
                              <input type="text" class="form-control paid_amount" name="paid_amount[]" id="paid_amount" placeholder="Amount" required>
                          </td>
                          <td>
                              <button type="button" class="btn btn-danger hide">Delete</button>
                          </td>
                      </tr>

                      </tbody>
                  </table>

                  <div class="line aligncenter">
                      <div class="form-group row">
                          <div class="col-sm-12 col-form-label" align="right">
                              <button type="submit" class="btn purple-bg white-font" data-original-title="" title=""> <i class="feather icon-save"></i>Save</button>
                              {{--<button type="reset" class="btn btn btn-outline-danger" data-original-title="" title=""> <i class="feather icon-refresh-ccw"></i> Cancel</button>--}}
                          </div>
                      </div>
                  </div>
              </form>

        </div>
         </div>

    </div>
 </div>

</div>




{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $(".add-row").on('click', function(){
            var table = $('.payment_details_table');
             var nrow = table.find('tr:eq(1)').clone();
             nrow.find('td').find('button').removeClass('hide');
            table.append(nrow);
        });

        // Find and remove selected table rows
        $('body').on('click','.btn', function(){
           $(this).closest("tr").remove();
        });
    });

    $(document).ready(function(){
        $('.js-example-basic-single').select2();
    });


</script>





@endsection



