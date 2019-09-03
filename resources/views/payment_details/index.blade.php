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
                            {{--<a href="{{route('Voucher',$payment->id)}}" class="btn btn-sm  btn-info"><i class="fab fa-amazon-pay"></i>Vocher</a>--}}
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Payment ID: </label>


                                {{$payment->id }}
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Payment Date: </label>
                                {{date('d-m-Y',strtotime($payment->created_at))}}
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Projects</th>
                                <th>Demand Amount(BDT) </th>
                                <th>Paid Amount</th>

                            </tr>
                            </thead>


                            <tbody>
                            @php
                                $i=0;

                            @endphp

                            @foreach($payment->Payment_details as $detail )
                                @php
                                    $i++ ;
                                @endphp

                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$detail->project['p_name']}}</td>
                                <td>{{$detail->demand_amount}}</td>
                                <td>{{$detail->paid_amount}}</td>
                                {{--<td>--}}
                                    {{--<input type="hidden" name="project_id[]" value="{{$detail->project['id']}}">--}}
                                    {{--<input type="text" name="amendment_amount[]" class="form-control">--}}
                                {{--</td>--}}
                            </tr>

                            @endforeach

                            </tbody>

                        </table>

                    </div>



        </div>
    </div>

    </div>
    </div>

@endsection