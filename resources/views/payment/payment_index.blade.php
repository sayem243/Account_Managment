@extends('admin.index')
@section('template')

 <div class="col-sm-12">
   <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
         <h5>Advance Payment</h5>
            <div class="card-header-right">
                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                    <a href="{{route('payment_create')}}" class="btn btn-sm  btn-info"><i class="fas fa-sign-out-alt"></i>Add New</a>
                </div>

                <div class="btn-group card-option">
                    <button type="button" class="btn dropdown-toggle btn-more" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-original-title="" title="">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right" x-placement="bottom-end">

                        <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                        <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                        <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>

                    </ul>
                </div>

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

                    {{--<th>Checked By</th>--}}
                    {{--<th>Approved By</th>--}}

                    <th>Demand(BDT)</th>
                    <th>Paid(BDT)</th>
                    <th>Amendment</th>
                    <th>Status </th>

                    <th>Remarks</th>
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

                        <td>{{$payment->user->UserProfile->company['name']}}</td>

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
                            {{--<a href="{{route('printPDF',$payment->id)}}">Print PDF</a>--}}

                                @if($payment->status == 1)
                                    <span class="label label-primary">Created</span>
                                @elseif($payment->status == 2)
                                    <span class="label label-warning">Verified</span>
                                @elseif($payment->status == 3)
                                    <span class="label label-success">Approved</span>

                                @endif

                        </td>

                        <td>{{$payment->comments}}</td>

                            <td>
                                @if($payment->status==1)
                                <button data-id="{{$payment->id}}" type="button" class="btn btn-sm  btn-primary approved">Verified </button>
                                @endif
                            </td>


                        <td>
                            <div class="btn-group card-option">
                               <a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                               <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">

                                  @if($payment->status==1)
                                   <li class="dropdown-item">
                                       <a href="{{route('payment_edit',$payment->id)}}">
                                           <i class="feather icon-edit"></i>
                                           Edit</a>
                                   </li>
                                       <li class="dropdown-item">
                                           <a href="{{route('delete',$payment->id)}}">
                                               <i class="feather icon-trash-2"></i>
                                               Remove</a>
                                       </li>

                                   @endif
                                   <li class="dropdown-item">
                                       <a href="{{route('details',$payment->id)}}">
                                           <i class="feather icon-eye"></i>
                                           Details</a>
                                   </li>

                                   <li class="dropdown-item">
                                       <a href="{{route('amendment_create',$payment->id)}}">
                                           <i class="feather icon-check-square"></i>
                                           Amendment
                                       </a>
                                   </li>
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


