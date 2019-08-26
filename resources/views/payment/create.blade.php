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

         <div class="card-block">
          <div class="card-body">

              <form class="form-horizontal" action="{{ route('payment_store')}}" method="post" enctype="multipart/form-data">

                 {{ csrf_field() }}

          <div class="row">
              <div class="col-md-6">


                  <div class="form-group">
                      <label class="col-form-label" for="demand_amount">Demand Amount:<span class="required">*</span></label>
                      <div class="col-form-label">
                          <input type="text" class="form-control" name="demand_amount" id="demand_amount" aria-describedby="validationTooltipUsernamePrepend" required="">
                      </div>
                  </div>

                  <div class="form-group">
                <label class="col-form-label" for="payment_amount">Payment Amount:</label>
                <div class="col-form-label">
                <input type="text" class="form-control" name="payment_amount" id="payment_amount" aria-describedby="validationTooltipUsernamePrepend" required="" >
            </div>
        </div>



        <div class="form-group">
            <label class="col-form-label" for="company_id">Company:</label>
            <div class="col-form-label">

                <select class="form-control" name="company_id">
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"> {{$company->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-group">
            <label class="col-form-label" for="user_id">Received By:</label>
            <div class="col-form-label">

                <select class="form-control" name="user_id">
                    <option value="">Received By</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}"> {{$user->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>

              </div>



  <div class="col-md-6">

        <div class="form-group">
            <label class="col-form-label" for="project_id">Projects</label>
            <div class="col-form-label" >
                <select class="form-control"  name="project_id" multiple id="multiple">
                    <option value=""></option>
                    @foreach($projects as $project)
                        <option value="{{$project->id}}"> {{$project->p_name}} </option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-group">
            <label class="col-form-label" for="comments">Comments </label>
            <div class="col-form-label">
                <textarea type="text" class="form-control" rows="8" name="comments" id="comments" aria-describedby="name">
                </textarea>

        </div>
        </div>




    </div>

          </div>
                  <div class="separator"></div>
                  <div class="line aligncenter">

                      <div class="form-group row">
                          <div class="col-sm-3 col-form-label"></div>
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

</div>

    {{--jquery Add row--}}


<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <style type="text/css">
                    form{
                        margin: 20px 0;
                    }
                    form input, button{
                        padding: 5px;
                    }
                    table{
                        width: 100%;
                        margin-bottom: 20px;
                        border-collapse: collapse;
                    }
                    table, th, td{
                        border: 1px solid #cdcdcd;
                    }
                    table th, table td{
                        padding: 10px;
                        text-align: left;
                    }
                </style>
                <div class="card-block">
                    <div class="card-body">

                        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $(".add-row").click(function(){

                                    var payement = $("#payement").val();
                                    var demand_amount = $("#demand_amount").val();
                                    var project = $("#project_id").val();
                                    var  paid_amount=$("#paid_amount").val();
                                    var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + payement + "</td><td>" + demand_amount + "</td><td>" + project + "</td> <td>" + paid_amount + "</td></tr>";
                                    $("table tbody").append(markup);
                                });

                                // Find and remove selected table rows
                                $(".delete-row").click(function(){
                                    $("table tbody").find('input[name="record"]').each(function(){
                                        if($(this).is(":checked")){
                                            $(this).parents("tr").remove();
                                        }
                                    });
                                });
                            });
                        </script>

                        <form>
                            <input type="text" id="payement" placeholder="payement">
                            <input type="text" id="demand_amount" placeholder="demand_amount">
                            <input type="text" id="project_id" placeholder="project_id">
                            <input type="text" id="paid_amount" placeholder="paid_amount">

                            <input type="button" class="add-row" value="Add Row">
                        </form>
                        <table>
                            <thead>
                            <tr>
                                <th>Select</th>
                                <th>Payment</th>
                                <th>Demand</th>
                                <th>Project</th>
                                <td>Paid Amount</td>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                 <input type="checkbox" name="record"></td>
                                <td>Md</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            </tbody>
                        </table>
                        <button type="button" class="delete-row">Delete Row</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection



