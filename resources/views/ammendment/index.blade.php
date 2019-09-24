@extends('admin.index')
@section('template')

    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">
                <h5 > Amendment </h5>
                <div class="card-block">

                <table class="table table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Payment ID</th>
                        <th>Demand Amount(BDT)</th>
                        <th>Advance Payment</th>
                        <th>Project</th>
                        <th>Amendment</th>
                        <th>status</th>
                        <th>Total Paid Amount</th>

                        <th>Due</th>
                        <th>Date</th>


                        <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                            <i class="feather icon-settings"></i>

                        </th>

                    </tr>
                    </thead>

                @php $i=0; @endphp

                @foreach($amendments as $amendment)
                    @php $i++ @endphp

                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$amendment->payment->payment_id}}</td>
                        <td>{{$amendment->payment->total_demand_amount}}  </td>
                        <td>{{$amendment->payment->total_paid_amount}} BDT </td>
                        <td>{{$amendment->project['p_name']}}</td>
                        <td>{{ $amendment->amendment_amount }}</td>
                        <td></td>

                        <td> {{ $sum=$amendment->amendment_amount+ $amendment->payment->total_paid_amount }} </td>


                        <td> {{ $amendment->payment['total_demand_amount'] - $sum }} </td>
                        <td>
                            {{ \Carbon\Carbon::parse($amendment->created_at)->format('d/m/Y')}}

                        </td>
                        <td></td>

                    </tr>

                    @endforeach

                </table>
                </div>

            </div>
        </div>
    </div>
@endsection
