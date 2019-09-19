@extends('admin.index')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Voucher Details</h5>
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
                    <table class= "table table-bordered">

                        <thead class="thead-dark">
                        <tr>
                            <th>Serial</th>
                            <th>Payment ID</th>
                            <th>Project</th>
                            <th>Amount</th>
                            <th>Date</th>

                            <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                                <i class="feather icon-settings"></i>
                            </th>
                        </tr>
                        </thead>

                        @php $i=0; @endphp
                        @foreach($details->vocher_details as $detail)
                            @php $i++ @endphp

                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$detail->payment->payment_id}}</td>
                                <td>{{$detail->project['p_name']}}</td>
                                {{--<td>{{$detail}}</td>--}}

                                {{--<td>{{$detail->payment_details->demand_amount}}</td>--}}
                                <td>{{$detail->amount}}</td>
                                <td>{{date('d-m-y',strtotime($detail->created_at))}}</td>


                                <td>
                                    <div class="btn-group card-option">
                                        <a href="javascript:"class="btn btn-notify btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                        <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
                                            <li class="dropdown-item">
                                                <a href="{{route('voucher_edit',$detail->id)}}">
                                                    <i class="feather icon-edit"></i>
                                                    Edit</a>
                                            </li>

                                            <li class="dropdown-item">
                                                <a href="{{route('voucher_delete',$detail->id)}}">
                                                    <i class="feather icon-trash-2"></i>
                                                    Remove</a>
                                            </li>

                                        </ul>

                                    </div>
                                </td>

                            </tr>
                        @endforeach


                    </table>


                </div>
            </div>
        </div>
    </div>
    </div>




@endsection