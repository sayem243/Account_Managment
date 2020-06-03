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
                    <th>Demand(BDT)</th>
                    <th>Paid(BDT)</th>
                    <th>Amendment</th>
                    <th>Status </th>
                    {{--<th>Remarks</th>--}}
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
                            {{$payment->total_demand_amount}}
                        </td>

                        <td>
                            {{$payment->total_paid_amount}}
                        </td>

                        <td>{{$payment->total_amendment_amount}}</td>

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

                            {{--<td>{{$payment->comments}}</td>--}}

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

                            {{----}}
                            {{--<div class="btn-group-vertical">--}}
                                {{--<a href="{{route('payment_edit',$payment->id)}}" button type="button" class="btn btn-sm  btn-info" >Edit </a>--}}
                                {{--<a href="{{route('delete', $payment->id)}}" button type="button" class="btn btn-sm  btn-info">Delete</a>--}}

                            {{--</div>--}}


                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>

              <ul class="pagination justify-content-end">
                  {{$payments->links('vendor.pagination.bootstrap-4')}}
              </ul>

              {{--{!! $payments->links() !!}--}}

        </div>

    </div>
    </div>

 </div>
 </div>
@endsection

@section('footer.scripts')

@endsection
