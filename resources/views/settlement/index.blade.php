@extends('admin.index')
@section('title','Payment Settlement List')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Payment Settlement</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered dataTable no-footer">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Payment ID</th>
                                <th>Project</th>
                                <th>Amount(BDT)</th>
                                <th>Advance Payment</th>
                                <th>Due</th>
                                <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                                    <i class="feather icon-settings"></i>
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @php $i=0; @endphp
                            @foreach($settlements as $settlement)

                                @php $i++ @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$settlement->payment->payment_id }}</td>
                                    <td>{{$settlement->project['p_name']}}</td>
                                    <td>{{ $settlement->settlement_amount }}</td>
                                    <td>{{$settlement->payment->total_paid_amount}}  </td>
                                    <td></td>

                                    <td class="status">

                                    </td>

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
