{{--@extends('layout.Master')--}}

{{--@section('content')--}}

@extends('admin.index')
@section('template')
<head><link rel="stylesheet" href="{{asset('assets/css/style.css')}}"></head>


    <div class="card">
        <div class="card-header">
           Payment
            <div class="btn-group-horizontal" style="text-align: right">
            {{--<a href="{{route('payment_create')}}" button type="button" class="btn btn-primary" >Add payment </a>--}}
                <a class="btn-floating btn-large waves-effect waves-light red" href="{{route('payment_create')}}"><i class="material-icons">add</i></a>

            </div>
        </div>




        <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>User Name</th>
                        <th>Company Name </th>
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
                                    <a href="{{route('payment_edit',$payment->id)}}" button type="button" class="btn btn-primary" >Edit </a>
                                    <a href="{{route('delete', $payment->id)}}" button type="button" class="btn btn-primary">Delete</a>

                                </div>


                                {{--<div class="btn-group">--}}
                                    {{--<button type="button" class="btn btn-primary">Action</button>--}}
                                    {{--<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">--}}
                                        {{--<span class="caret"></span>--}}
                                    {{--</button>--}}
                                    {{--<ul class="dropdown-menu" role="menu">--}}
                                        {{--<li><a href="{{route('edit',$payment->id)}}">Edit</a></li>--}}
                                        {{--<li><a href="{{route('delete',$payment->id)}}">Delete</a></li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}

                            </td>


                        </tr>

                    @endforeach


                    </tbody>
                </table>


        </div>
    </div>










@endsection