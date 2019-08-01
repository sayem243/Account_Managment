@extends('admin.index')
@section('template')



    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">

                        <h5>Advance Payment</h5>
            <div class="btn-group-horizontal" style="text-align: right">

                <a class="btn btn-sm  btn-info"  href="{{route('payment_create')}}" class=""><i class="fas fa-sign-out-alt">Add</i></a>

            </div>

        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>SL</th>
                    <th>User Name</th>
                    <th>Company </th>
                    <th>Project</th>
                    <th>Demand  Amount</th>
                    <th>Paid Amount</th>
                    <th>Approval </th>
                    <th>Due</th>
                    <th>comments</th>
                    <th>Amendments</th>
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

                        <td>
                            {{--<a href="{{route('printPDF',$payment->id)}}">Print PDF</a>--}}
                        </td>

                        <td>
                            @php
                                $sum=$payment->d_amount-$payment->due;

                            @endphp

                            {{$sum}}
                        </td>



                        <td>{{$payment->comments}}</td>

                        <td> <a href="{{route('amendment_create',$payment->id)}}" class="btn btn-success">Click </a>

                        </td>



                        <td>
                            {{----}}
                            {{--<a href="{{route('edit',$payment->id)}}" class="btn btn-success">Edit </a>--}}
                            {{--<a href="{{route('delete',$payment->id)}}" class="btn btn-danger">Delete </a>--}}


                           <div class="btn-group card-option">
                               <button type="button" class="btn btn-notify" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
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


        </div>



    </div>
    </div>






@endsection