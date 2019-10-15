@extends('admin.index')
@section('template')

<div class="col-sm-12">
 <div class="row">
   <div class="col-sm-12">
      <div class="card">
          <div class="card-header">
              <h5>Add Payment</h5>
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
                      <label for="exampleInputEmail1">Recived By</label>
                      <select class="form-control js-example-basic-single" name="user_id" id="user_id" required>

                          <option value="">Select User</option>
                          @foreach($users as $user)
                              <option value="{{$user->id}}"> {{$user->name}} </option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="form-group">
                      <label for="comments">Comments</label>
                      <textarea name="comments" rows="3.5" class="form-control"></textarea>
                  </div>
              </div>
          </div>


                  <div class="col-md-12">
                      <h5 align="center" class="text-primary mb-1">Advance Payment</h5>
                  </div>

                  <table class="table table-bordered payment_details_table">
                      <thead class="thead-dark">
                      <tr>
                          <th>Project</th>
                          <th>Demand Amount</th>
                          <th>Paid Amount</th>
                          <th>File</th>
                          <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <div class="col-sm-12 col-form-label" align="right">
                          <input type="button" class="btn btn-info add-row" value="Add Row">
                      </div>
                      <tr>
                          <td>
                              <select class="form-control user_project_list" name="project_id[]" required>
                                  <option value="">Select Project</option>
                              </select>
                          </td>
                          <td>
                              <input type="text" class="form-control demand_amount" name="demand_amount[]" id="demand_amount">
                          </td>
                          <td>
                              <input type="text" class="form-control paid_amount" name="paid_amount[]" id="paid_amount">
                          </td>

                          <td>
                              <input type="file" class="form-control" name="filenames[]" id="filenames" placeholder="">
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



