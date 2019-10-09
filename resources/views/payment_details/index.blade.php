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
                            @if($payment->status==1)
                            <button data-id-id="{{$payment->id}}" type="button" class="btn btn-sm  btn-primary approved">Approved </button>
                            <button data-id="{{$payment->id}}" type="button" class="btn btn-sm  btn-warning verify">Verified </button>
                                {{--<a href="{{route('Voucher',$payment->id)}}" class="btn btn-sm  btn-info"><i class="fab fa-amazon-pay"></i>Vocher</a>--}}
                                @elseif($payment->status==2)
                                <button data-id-id="{{$payment->id}}" type="button" class="btn btn-sm  btn-primary approved">Approved </button>
                            @endif

                        </div>

                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle btn-more" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-original-title="" title="">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right" x-placement="bottom-end">

                                <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                               <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                               <li class="dropdown-item reload-card"><a href="{{route('printPDF',$payment->id)}}"><i class="far fa-file-pdf"></i> PDF</a></li>
                               <li class="dropdown-item reload-card"><a href="{{route('details_delete',$payment->id)}}"><i class="feather icon-trash-2"></i> Delete</a></li>


                            </ul>
                        </div>

                    </div>
                </div>

                    {{--Advance Payment Information--}}

                    <div class="card-body">
                        <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Employe Name: </label>
                                {{--{{$payment->user['name'] }}--}}
                                {{$payment->user->UserProfile['fname'].' '.$payment->user->UserProfile['lname']}}
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Payment Date: </label>
                                {{date('d-m-Y',strtotime($payment->created_at))}}
                            </div>
                            <div class="form-group">
                                <label for="">Company: </label>
                                {{$payment->user->userProfile->company['name']}}
                            </div>
                        </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Payment ID: </label>
                                    {{$payment->payment_id }}
                                </div>


                                <div class="form-group">
                                    <label for="">Mobile Number: </label>
                                    {{$payment->user->userProfile['mobile'] }}
                                </div>

                                <div class="form-group">

                                    <label for="">Verified By:</label>
                                        {{$payment->verifiedBy['name']}}
                                </div>


                                <div class="form-group">
                                    @if($payment->status==3)

                                    <label for="">Approved By: </label>
                                        {{$payment->approvedBy['name']}}
                                    @endif
                                </div>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for=""><b>Remarks : </b></label>
                                {{$payment->comments}}
                            </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <h4 align="center">Advance Payment Details</h4>
                        </div>

                        <table class="table table-striped table-bordered dataTable no-footer ">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Projects</th>
                                <th>Demand Amount(BDT) </th>
                                <th>Paid Amount</th>
                                <th> File </th>
                                <th>Date</th>

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
                                <td><a href="{{asset('files/'.$detail->filenames)}}" download>Download</a> </td>

                                {{--<td>{{$detail->filenames}}</td>--}}

                                <td> {{date('d-m-Y',strtotime($detail->created_at))}}</td>
                                {{--<td>--}}
                                    {{--<input type="hidden" name="project_id[]" value="{{$detail->project['id']}}">--}}
                                    {{--<input type="text" name="amendment_amount[]" class="form-control">--}}
                                {{--</td>--}}
                            </tr>

                            @endforeach

                            </tbody>

                        </table>


                        <div class="col-md-12">
                            <h4 align="center">Amendment Details</h4>
                        </div>

                        <table class="table table-striped table-bordered dataTable no-footer">
                            <thead class="thead-dark" >
                            <tr>
                                <th>SL</th>
                                <th>Projects</th>
                                <th>Amendment Amount</th>
                                <th>status</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach($payment->ammendments as $detail )
                                @php
                                    $i++ ;
                                @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$detail->project['p_name']}}</td>
                                    <td>{{$detail->amendment_amount}}</td>
                                    <td class="status">
                                        @if($detail->status == 1)
                                            <span class="label label-primary">Created</span>
                                        @elseif($detail->status == 2)
                                            <span class="label label-success">Approved</span>

                                        @endif
                                    </td>

                               <td><button data-id="{{$detail->id}}" type="button" class="btn btn-sm  btn-primary amendment_approved">Approved</button></td>

                                    <td> {{date('d-m-Y',strtotime($detail->created_at))}}</td>
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