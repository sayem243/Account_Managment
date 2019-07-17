{{--@extends('layout.Master')--}}

{{--@section('content')--}}

@extends('admin.index')
@section('template')

    <div class="container">
        <h2>Payment Table </h2>
        <p>Payment </p>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>serial</th>
                <th>User Name</th>
                <th>Company Name </th>
                <th>Select Project</th>

                <th>Demand  Amount</th>
                <th>Disbursment Amount</th>
                <th>Approval </th>
                <th>Due</th>

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

                    </td>

                    <td>
                        @php
                            $sum=$payment->d_amount-$payment->due;

                        @endphp

                        {{$sum}}



                    </td>



                </tr>

            @endforeach


            </tbody>
        </table>
    </div>




@endsection