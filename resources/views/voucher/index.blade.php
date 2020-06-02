@extends('admin.index')
@section('title','-Settlement')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Settlement</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                                <a href="{{route('voucher_create')}}" class="btn btn-sm  btn-info"><i class="fas fa-sign-out-alt"></i>Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered dataTable no-footer">
                                <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Payment ID</th>
                                    <th>Employe Name</th>
                                    <th>Company</th>
                                    <th>Settlement ID</th>
                                    <th>Advance Paid</th>
                                    <th>Received</th>
                                    <th>Balance</th>
                                    <th>status</th>
                                    <th>Actions</th>


                                    <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                                        <i class="feather icon-settings"></i>
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @php $i=0; @endphp
                                @foreach($vochers as $vocher)
                                    @php $i++ @endphp

                                    <tr>
                                        <td>{{$i}}</td>

                                        <td>{{ date('d-m-Y',strtotime($vocher->created_at))}}</td>

                                        <td>  @foreach($vocher->Vocher_details as $vocher_detail)
                                                  {{$vocher_detail->payment->payment_id}},
                                                @endforeach
                                        </td>
                                        <td>{{$vocher->user->userprofile['fname']}} {{$vocher->user->userprofile['lname']}}</td>
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
                                        <td>
                                            @if($vocher->status==1 )
                                            <button data-id-id="{{$vocher->id}}" type="button" class="btn btn-sm  btn-primary voucher-approve">Approve</button>
                                                @endif
                                        </td>

                                        <td>
                                            <div class="btn-group card-option">
                                                <a href="javascript:"  class="btn btn-notify btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
                                                    @if($vocher->status==2)

                                                    <li class="dropdown-item">
                                                        <a href="{{route('voucherDetails_index',$vocher->id)}}">
                                                            <i class="feather icon-eye"></i>
                                                            Details</a>
                                                    </li>
                                                     @elseif($vocher->status==1)
                                                        <li class="dropdown-item">
                                                            <a href="{{route('voucherDetails_index',$vocher->id)}}">
                                                                <i class="feather icon-eye"></i>
                                                                Details</a>
                                                        </li>

                                                        <li class="dropdown-item">
                                                            <a href="{{route('voucher_edit',$vocher->id)}}">
                                                                <i class="feather icon-edit"></i>
                                                                Edit</a>
                                                        </li>

                                                        <li class="dropdown-item">
                                                            <a href="{{route('voucher_delete',$vocher->id)}}">
                                                                <i class="feather icon-trash"></i>
                                                                Delete</a>
                                                        </li>

                                                    @endif

                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        <ul class="pagination justify-content-end">
                            {{$vochers->links('vendor.pagination.bootstrap-4')}}
                        </ul>
                </div>
            </div>
        </div>
    </div>

    </div>


@endsection




