@extends('layout')
@section('title','Advance Payment')
@section('template')

 <div class="col-sm-12">
   <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
         <h5>Advance Payment</h5>
            <div class="card-header-right">
                @if(auth()->user()->can('Payment-create'))
                    <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                        <a href="{{route('payment_create')}}" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
                    </div>
                @endif

            </div>

        </div>
          <div class="card-body payment_table">

              {{--{!! $payments->links() !!}--}}
              <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                  <thead class="thead-dark">
                  <tr role="row" class="filter">
                      <td colspan="2">
                          <input  type="text" class="form-control form-filter input-sm" name="payment_id" id="payment_id" placeholder="Payment Id"> </td>

                      </td>

                      <td colspan="2">
                          <select class="form-control" name="company_id" id="company_id" aria-describedby="validationTooltipPackagePrepend" required>
                              <option value="">All Company</option>
                              @foreach($companies as $company)
                                  <option value="{{ $company->id }}">{{ $company->name }}</option>
                              @endforeach
                          </select>
                      </td>
                      <td>
                          <select class="form-control" name="project_id" id="project_id">
                              <option value="">All Project</option>
                              @foreach($projects as $project)
                                  <option value="{{ $project->id }}">{{ $project->p_name }}</option>
                              @endforeach
                          </select>
                      </td>


                      <td colspan="1">
                          <select class="form-control" name="user_id" id="user_id" >
                              <option value="">All User</option>
                              @foreach($users as $user)
                                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                              @endforeach
                          </select>
                      </td>
                      <td colspan="3"></td>
                  </tr>
                  <tr>
                      <th scope="col">S/N</th>
                      <th width="80px" scope="col">Date</th>
                      <th width="100px" scope="col">HS ID</th>
                      <th scope="col">Name</th>
                      <th width="150px" scope="col">Company</th>
                      <th width="120px" scope="col">Amount</th>
                      <th scope="col">Status</th>
                      <th scope="col text-center">Action</th>
                      <th scope="col text-center"><i class="feather icon-settings"></i></th>
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
@endsection

@section('footer.scripts')
    <script src="{{ asset("assets/datatable/payment.js") }}" ></script>
@endsection
