@extends('admin.index')
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
          <div class="card-body">
              <table class="table table-striped table-bordered dataTable no-footer">
                <thead class="thead-dark">
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Invoice ID</th>
                    <th>Employe Name</th>
                    <th>Company</th>
                    <th>Created By</th>
                    <th>Amount(BDT)</th>
                    <th>Status </th>
                    <th>Actions</th>
                    <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                        <i class="feather icon-settings"></i>
                    </th>
                </tr>
                </thead>
                <tbody>

                @php $i=0; @endphp
                @foreach($payments as $payment)
                    @php $i++ @endphp

                    <tr>
                        <td>{{$i}}</td>
                        <td>{{ date('d-m-Y', strtotime($payment->created_at))}}</td>

                        <td>{{$payment->payment_id}} </td>
                        <td>
                            {{$payment->user->UserProfile['fname'].' '.$payment->user->UserProfile['lname']}}
                        </td>

                        <td>{{$payment->user->UserProfile?$payment->user->UserProfile->company['name']:''}}</td>

                        <td>

                            {{$payment->userCreatedBy['name']}}
                            {{--{{$payment->userCreatedBy->UserProfile['fname'].' '.$payment->userCreatedBy->UserProfile['lname']}}--}}
                        </td>

                        {{--<td> {{$payment->userCreatedBy['name']}}</td>--}}

                        {{--<td>{{$payment->approvedBy['name']}}</td>--}}

                        <td>
                            {{$payment->total_paid_amount}}
                        </td>
                        <td class="status">
                                @if($payment->status == 1 && $payment->verified_by ==null)
                                    <span class="label label-primary">Created</span>
                                @elseif($payment->status == 1 && $payment->verified_by !=null)
                                    <span class="label label-primary">Un verified</span>
                                @elseif($payment->status == 2)
                                    <span class="label label-warning">Verified</span>
                                @elseif($payment->status == 3)
                                    <span class="label label-success">Approved</span>
                                @elseif($payment->status==4)
                                    <span class="label label-info">Disbursed</span>
                                @endif

                        </td>

                        <td>
                            @if($payment->status==1 and 'payment-approve')

                                @can('payment-verify')
                                    <button data-id="{{$payment->id}}" data-status="2" type="button" class="btn btn-sm  btn-primary verify">Verify </button>
                                @endcan

                            @elseif($payment->status==2 and 'payment-approve')
                                @can('payment-approve')
                                    <button data-id-id="{{$payment->id}}" type="button" class="btn btn-sm  btn-primary approved">Approve </button>
                                @endcan
                                @can('payment-verify')
                                    <button data-id="{{$payment->id}}" data-status="1" type="button" class="btn btn-sm  btn-primary verify">Un verify</button>
                                @endcan
                            @elseif($payment->status==3)
                                    @can('payment-paid')
                                    <button data-id-id="{{$payment->id}}" type="button" class="btn btn-sm btn-success payment_paid">Disburse</button>
                                    @endcan
                            @endif

                        </td>


                        {{--   <td>
                            @if($payment->status==1 )
                                <button data-id="{{$payment->id}}" type="button" class="btn btn-sm  btn-primary verify">Verify </button>
                               @elseif($payment->status==2 )
                                    <button data-id-id="{{$payment->id}}" type="button" class="btn btn-sm  btn-primary approved">Approve </button>
                                @endif
                            </td>--}}

                        <td>
                            <div class="btn-group card-option">
                               <a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                               <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">


                                   @if($payment->status==1)
                                       @if(auth()->user()->can('payment-edit'))
                                           <li class="dropdown-item">
                                               <a href="{{route('payment_edit',$payment->id)}}">
                                                   <i class="feather icon-edit"></i>
                                                   Edit
                                               </a>
                                           </li>
                                       @endif


                                   @if(auth()->user()->can('payment-delete'))
                                   <li class="dropdown-item">
                                       <a href="{{route('delete',$payment->id)}}">
                                           <i class="feather icon-trash-2"></i>
                                           Remove</a>
                                   </li>
                                       @endif
                                   @endif


                                   <li class="dropdown-item">
                                       <a href="{{route('details',$payment->id)}}">
                                           <i class="feather icon-eye"></i>
                                           Details</a>
                                   </li>
                                    @if($payment->status==3 || $payment->status==4)
                                   <li class="dropdown-item">
                                       <a href="{{route('amendment_create',$payment->id)}}">
                                           <i class="feather icon-check-square"></i>
                                           Amendment
                                       </a>
                                   </li>
                                        @endif
                               </ul>
                           </div>

                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>

              {{--<ul class="pagination justify-content-end">
                  {{$payments->links('vendor.pagination.bootstrap-4')}}
              </ul>--}}

              {{--{!! $payments->links() !!}--}}
              <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                  <thead class="thead-dark">
                  <tr role="row" class="filter">
                      <td colspan="2">
                          <input  type="text" class="form-control form-filter input-sm" name="customerName" id="customerName" placeholder="Name"> </td>

                      </td>

                      <td>
                          <select class="form-control" name="company_id" id="company_id" aria-describedby="validationTooltipPackagePrepend" required>
                              <option value="">Select Company</option>
                              @foreach($companies as $company)
                                  <option value="{{ $company->id }}">{{ $company->name }}</option>
                              @endforeach
                          </select>
                      </td>
                      <td>
                          <select class="form-control" name="project_id" id="project_id">
                              <option value="">Select Project</option>
                              @foreach($projects as $project)
                                  <option value="{{ $project->id }}">{{ $project->p_name }}</option>
                              @endforeach
                          </select>
                      </td>


                      <td>
                          <select class="form-control" name="user_id" id="filter_user_id" >
                              <option value="">Select User</option>
                              @foreach($users as $user)
                                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                              @endforeach
                          </select>
                      </td>
                      <td colspan="4"></td>
                  </tr>
                  <tr>
                      <th scope="col">S/N</th>
                      <th scope="col">Date</th>
                      <th scope="col">ID</th>
                      <th scope="col">Company</th>
                      <th scope="col">Amount</th>
                      <th scope="col">Created By</th>
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
