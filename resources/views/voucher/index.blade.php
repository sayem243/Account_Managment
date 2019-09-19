@extends('admin.index')
@section('title','-Voucher')
@section('template')


    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Voucher</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                                <a href="{{route('voucher_create')}}" class="btn btn-sm  btn-info"><i class="fas fa-sign-out-alt"></i>Add New</a>
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
                            <table class= "table table-bordered">

                                <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Payment ID</th>
                                    <th>Employe Name</th>
                                    <th>Company</th>
                                    <th>Voucher ID</th>
                                    <th>Paid Amount</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                    <th>status</th>
                                    <th>Actions</th>
                                    <th>Date</th>

                                    <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                                        <i class="feather icon-settings"></i>
                                    </th>
                                </tr>
                                </thead>

                                @php $i=0; @endphp
                                @foreach($vochers as $vocher)
                                    @php $i++ @endphp

                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>  @foreach($vocher->Vocher_details as $vocher_detail)
                                                  {{$vocher_detail->payment->payment_id}},
                                                @endforeach
                                        </td>
                                        <td>{{$vocher->user['name']}}</td>
                                        <td>{{$vocher->user->userprofile->company['name']}}</td>
                                        <td>{{$vocher->voucher_id}}</td>
                                        <td>
                                            <?php $total = 0;?>
                                            @foreach($vocher->Vocher_details as $vocher_detail)
                                                <?php
                                                $total+= App\Http\Controllers\VocherController::paidAmountByPaymentAndProject($vocher_detail->payment_id, $vocher_detail->project_id); ?>
                                            @endforeach
                                            <?php echo $total;?>
                                            </td>

                                        <td>{{$vocher->total_amount}}</td>
                                        <td>{{$total-$vocher->total_amount}}</td>

                                        <td class="status">
                                            @if($vocher->status == 1)
                                                <span class="label label-primary">Created</span>
                                            @elseif($vocher->status == 2)
                                                <span class="label label-success">Approved</span>
                                            @endif
                                        </td>
                                        <td> <button data-id-id="{{$vocher->id}}" type="button" class="btn btn-sm  btn-primary voucher-approve">Approved</button></td>

                                        <td>{{ date('d-m-Y',strtotime($vocher->created_at))}}</td>

                                        <td>
                                            <div class="btn-group card-option">
                                                <a href="javascript:"  class="btn btn-notify btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
                                                    <li class="dropdown-item">
                                                        <a href="{{route('voucherDetails_index',$vocher->id)}}">
                                                            <i class="feather icon-eye"></i>
                                                            Details</a>
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




