@extends('admin.index')

@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
            <div class="card-header">
                <h5> Payment Details </h5>

                    <div class="card-header-right">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                            <a href="{{route('payment_create')}}" class="btn btn-sm  btn-info"><i class="fas fa-sign-out-alt"></i>Add New</a>
                            <a href="{{route('Voucher',$payment->id)}}" class="btn btn-sm  btn-info"><i class="fab fa-amazon-pay"></i>Vocher</a>


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

                    {{--Advance Payment Information--}}

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Company </th>
                                        <th>Project</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <td>{{$payment->user['name']}} </td>
                                    <td>{{$payment->company['name']}}</td>
                                    <td>{{$payment->project['p_name']}}</td>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Demand Amount</th>
                                        <th> Initial Paid </th>
                                        <th>Total Paid</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <td>{{$payment->total_demand_amount}}</td>
                                    <td>{{$payment->total_paid_amount}}</td>
                                    {{--<td>{{$total+$payment->due}}</td>--}}

                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <table class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Amount (BDT) </th>
                                <th>Date</th>
                            </tr>
                            </thead>

                            <tbody>

                            @php
                                $i=1;
                                $sum=0;
                            @endphp
                            @foreach($payment->ammendment as $ammendment)


                            <tr>
                             <td>{{$i}}</td>
                                {{--<td>{{$payment->user['name']}}</td>--}}
                                {{--<td>{{$payment->company['name']}}</td>--}}
                                {{--<td>{{$payment->project['p_name']}}</td>--}}
                                {{--<td>{{$payment->d_amount}}</td>--}}
                                <td> {{ $ammendment->additional_amount }} </td>

                                <td>{{date('d-m-Y', strtotime($ammendment->created_at))}}</td>




                            </tr>
                            @php
                                $sum += $ammendment->additional_amount;
                                $i++;

                            @endphp
                            @endforeach


                            <tr>
                               <th colspan="6"> Total Amendment  Amount={{$sum}}</th>
                            </tr>

                            </tbody>


                        </table>


                    </div>



        </div>
    </div>

    </div>
    </div>

@endsection