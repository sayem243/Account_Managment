@extends('admin.index')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Amendment</h5>
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
                        <table class="table table-striped table-bordered dataTable no-footer">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Payment ID</th>
                                <th>Project</th>
                                <th>Demand Amount(BDT)</th>
                                <th>Advance Payment</th>
                                <th>Amendment</th>
                                <th>status</th>
                                <th>Action</th>
                                <th>Total Paid Amount</th>
                                <th>Due</th>
                                <th>Date</th>
                                <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                                    <i class="feather icon-settings"></i>
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @php $i=0; @endphp
                            @foreach($amendments as $amendment)

                                @php $i++ @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$amendment->payment->payment_id}}</td>
                                    <td>{{$amendment->project['p_name']}}</td>

                                    <td>{{$amendment->payment->total_demand_amount}}  </td>
                                    <td>{{$amendment->payment->total_paid_amount}}  </td>

                                    <td>{{ $amendment->amendment_amount }}</td>

                                    <td class="status">
                                        @if($amendment->status == 1)
                                            <span class="label label-primary">Created</span>
                                        @elseif($amendment->status == 2)
                                            <span class="label label-success">Approved</span>


                                        @endif

                                    </td>


                                    <td><button data-id="{{$amendment->id}}" type="button" class="btn btn-sm  btn-primary amendment_approved">Approve </button>

                                    </td>


                                    <td> {{ $sum=$amendment->amendment_amount+ $amendment->payment->total_paid_amount }} </td>

                                    <td> {{ $amendment->payment['total_demand_amount'] - $sum }} </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($amendment->created_at)->format('d/m/Y')}}

                                    </td>
                                    <td></td>

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
