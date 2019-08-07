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
                        <th>user Name</th>
                        <th>Demand Amount</th>
                        <th>Advance Payment</th>
                        <th>Amendment</th>
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
                        <td> </td>

                        <td>{{$amendment->payment['d_amount']}} BDT </td>
                        <td>{{$amendment->payment['due']}} BDT </td>

                        <td>{{ $amendment->additional_amount }}</td>

                        <td> {{ $sum=$amendment->additional_amount+ $amendment->payment['due'] }} </td>

                        <td> {{ $amendment->payment['d_amount'] - $sum }} </td>
                        <td>
                            {{ \Carbon\Carbon::parse($amendment->from_date)->format('d/m/Y')}}

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
