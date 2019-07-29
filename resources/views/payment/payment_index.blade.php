@extends('admin.index')
@section('template')



    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">

                        Payment
            <div class="btn-group-horizontal" style="text-align: right">

                <a class="btn btn-sm  btn-info"  href="{{route('payment_create')}}" class=""><i class="fas fa-sign-out-alt">Add</i></a>

            </div>

        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>User Name</th>
                    <th>Company </th>
                    <th>Project</th>

                    <th>Demand  Amount</th>
                    <th>Paied Amount</th>
                    <th>Approval </th>
                    <th>Due</th>
                    <th>Action</th>

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
                            <a href="{{route('printPDF',$payment->id)}}">Print PDF</a>
                        </td>

                        <td>
                            @php
                                $sum=$payment->d_amount-$payment->due;

                            @endphp

                            {{$sum}}
                        </td>
                        <td>
                            {{----}}
                            {{--<a href="{{route('edit',$payment->id)}}" class="btn btn-success">Edit </a>--}}
                            {{--<a href="{{route('delete',$payment->id)}}" class="btn btn-danger">Delete </a>--}}

                            <div class="btn-group-vertical">
                                <a href="{{route('payment_edit',$payment->id)}}" button type="button" class="btn btn-sm  btn-info" >Edit </a>
                                <a href="{{route('delete', $payment->id)}}" button type="button" class="btn btn-sm  btn-info">Delete</a>

                            </div>




                        </td>


                    </tr>

                @endforeach


                </tbody>
            </table>


        </div>



    </div>
    </div>






@endsection