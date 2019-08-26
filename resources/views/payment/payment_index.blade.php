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
                    <th>User Name</th>
                    <th>Company </th>
                    <th>Project</th>
                    <th>Demand  Amount</th>
                    <th>Initial Paid</th>
                    <th>Status </th>
                    {{--<th>Due</th>--}}
                    <th>Remarks</th>
                    <th>Amendments</th>
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
                        <td>
                            {{$payment->user['name']}}
                        </td>

                        <td>
                            {{$payment->company['name']}}
                        </td>
                        <td>
                            {{$payment->project['p_name'] }}
                        </td>

                        <td>
                            {{$payment->d_amount}}
                        </td>

                        <td>
                            {{$payment->due}}
                        </td>

                        <td class="status">
                            {{--<a href="{{route('printPDF',$payment->id)}}">Print PDF</a>--}}

                                @if($payment->status == 0)
                                    <span class="label label-primary">Pending</span>
                                @elseif($payment->status == 1)
                                    <span class="label label-success">Approved</span>
                                @elseif($payment->status == 2)
                                    <span class="label label-danger">Rejected</span>
                                @else
                                    <span class="label label-info">Postponed</span>
                                @endif

                        </td>



                        {{--<td>--}}
                            {{--@php--}}
                                {{--$sum=$payment->d_amount-$payment->due;--}}

                            {{--@endphp--}}

                            {{--{{$sum}}--}}
                        {{--</td>--}}


                        <td>{{$payment->comments}}</td>


                        <td>
                            <a href="{{route('amendment_create',$payment->id)}}" class="btn btn-sm  btn-info">Add </a>

                        </td>
                        <td>
                            <button data-id="{{$payment->id}}" type="button" class="btn btn-sm  btn-primary approved">Approved </button>

                            <button data-id-id="{{$payment->id}}" type="button" class="btn btn-sm  btn-primary danger">Rejected </button>


                        </td>

                        <td>
                            {{----}}
                            {{--<a href="{{route('edit',$payment->id)}}" class="btn btn-success">Edit </a>--}}
                            {{--<a href="{{route('delete',$payment->id)}}" class="btn btn-danger">Delete </a>--}}

                            <div class="btn-group card-option">
                               <a href="javascript:"  class="btn btn-notify btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                               <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
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

                                   <li class="dropdown-item">
                                       <a href="{{route('details',$payment->id)}}">
                                           <i class="feather icon-eye"></i>
                                           Details</a>
                                   </li>

                                   {{--<li class="dropdown-item">--}}
                                       {{--<a href="{{route('status',$payment->id)}}">--}}
                                           {{--<i class="feather icon-eye"></i>--}}
                                           {{--status</a>--}}
                                   {{--</li>--}}


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





              

        </div>

    </div>
    </div>

 </div>
 </div>
@endsection


{{--Ajax --}}

{{--@section('scripts')--}}
    {{--<script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>--}}
    {{--<script>--}}

        {{--$('#status').change(function () {--}}

            {{--var st= $('#status').val();--}}


            {{--$('#status').html("");--}}
            {{--var option="";--}}
            {{--$.get( "http://127.0.0.1:8000/payment/status/check/"+st,--}}
                {{--function( data ) {--}}
                {{--data=JSON.parse(data)--}}
                    {{--data.forEach(function (element) {--}}
                        {{--console.log(element.status);--}}
                        {{----}}
                    {{--})--}}


                {{--$('#status').html("<option>1</option>")--}}

            {{--});--}}

            {{--alert(st);--}}
            {{----}}
        {{--})--}}


    {{--</script>--}}


    {{--@endsection--}}

