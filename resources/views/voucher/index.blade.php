@extends('admin.index')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Voucher</h5>
                        <div class="card-header-right">
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
                        <div  class="col-sm" align="right">
                            Date: {{ \Carbon\Carbon::parse($payment->from_date)->format('d/m/Y')}}
                        </div>
                        <div class="row">


                        <div class="col-md-6">

                            <div class="col-sm row">
                            <span>Name :</span>
                            <div class="col-sm">
                            {{$payment->user['name']}}
                            </div>
                            </div>

                            <div class="col-sm row">
                            <span >Company :</span>
                            <div class="col-sm">
                              {{$payment->company['name']}}
                            </div>
                            </div>

                            <div class="col-sm row">
                                <level >Project :</level>
                                <div class="col-sm">
                                  {{$payment->project['p_name']}}
                                </div>
                            </div>

                        </div>

                            <div class="col-md-6">

                                <div class="col-sm row">
                                    <level >Demand Amount :</level>
                                    <div class="col-sm">
                                        {{$payment->d_amount}}
                                    </div>
                                </div>

                                <div class="col-sm row">
                                    <level >Initial Paid :</level>
                                    <div class="col-sm">
                                        {{$payment->due}}
                                    </div>
                                </div>


                                <div class="col-sm row">
                                    <level>Total Paid :</level>
                                    <div class="col-sm">
                                        {{$total+$payment->due}}
                                    </div>
                                </div>

                                <div class="col-sm row">
                                    <level>Due :</level>
                                    <div class="col-sm">
                                        {{$payment->d_amount-($total+$payment->due)}}
                                    </div>
                                </div>

                          </div>
                    </div>

                        <div class="row">
                        <div class="col-sm-8">
                            <h5 align="center"> Amendment List </h5></div>
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