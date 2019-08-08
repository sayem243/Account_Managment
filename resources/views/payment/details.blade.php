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

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Advance Payment</th>
                                <th>Amendment List </th>
                            </tr>
                            </thead>

                            <tbody>

                            @php
                                $i=0;
                                $sum=0;
                            @endphp
                            @foreach($ammendments as $ammendment)



                            <tr>
                             <td>{{$i}}</td>

                             <td>{{$payment->d_amount}}</td>

                                <td> {{ $ammendment->additional_amount }}BDT </td>



                            </tr>
                            @php
                                $sum += $ammendment->additional_amount;
                                $i++;

                            @endphp
                            @endforeach


                            <tr>
                                <td></td>

                                <th colspan="2"> Total Paid Amount={{$sum}}</th>

                            </tr>



                            </tbody>


                        </table>


                    </div>







        </div>
    </div>

    </div>
    </div>

@endsection