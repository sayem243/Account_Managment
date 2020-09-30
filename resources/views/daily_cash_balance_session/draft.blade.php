@extends('layout')
@section('title','Confirm Payment')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5> Daily Opening Balance Session </h5>

                        <div class="card-header-right">
                            Date: {{isset($requestDate)?$requestDate:''}}
                        </div>
                    </div>

                    <form class="form-horizontal" action="{{ route('cash_balance_session_store_confirm')}}"
                          method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        {{--Advance Payment Information--}}
                        <div class="card-body" style="border: 1px solid #000; margin-bottom: 5px; padding-bottom: 0">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Company Name</th>
                                    <th>Opening balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=1 @endphp
                                @foreach($cashDailyBalanceSessions as $cashDailyBalanceSession)

                                    <tr>
                                        <td>
                                            <input type="hidden" value="{{$cashDailyBalanceSession->id}}"
                                                   name="session_id[{{$cashDailyBalanceSession->id}}]">
                                            {{$i}}
                                        </td>
                                        <td>
                                            {{$cashDailyBalanceSession->company->name}}
                                        </td>
                                        <td>{{$cashDailyBalanceSession->opening_balance}}
                                            <input type="hidden" class="form-control" name="opening_balance[{{$cashDailyBalanceSession->id}}]" value="{{$cashDailyBalanceSession->opening_balance}}">
                                        </td>
                                    </tr>

                                    @php $i++ @endphp
                                @endforeach
                                </tbody>

                            </table>

                            <div class="line aligncenter">
                                <div class="form-group">
                                    <div style="padding-right: 1px" class="col-sm-12 col-form-label btn-group-lg"
                                         align="right">
                                        <button style="margin-right: 0px" type="submit" class="btn btn-info"
                                                data-original-title="" title=""><i class="feather icon-save"></i>Save &
                                            Confirm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection

