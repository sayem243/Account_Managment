@extends('layout')
@section('title','Daily Cash Balance Session List')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Daily Opening Balance Session Start </h5>
                        <div class="card-header-right">
                            @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('daily-cash-balance-session'))
                                <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested">
                                    <form action="{{route('opening_balance_start')}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested">
                                            <button name="generate" value="generate" type="submit" class="btn btn-sm  btn-info">Daily Opening Balance Start</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>{{'Opening Balance'}}</th>
                                <th>{{'Closing Balance'}}</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cashBalanceSessions as $cashBalanceSession)

                                <tr>
                                    <td><a data-target-date="{{ date('Y-m-d', strtotime($cashBalanceSession->createdDate))}}" href="{{route('daily_cash_balance', ['filter_date' => date('Y-m-d', strtotime($cashBalanceSession->createdDate))])}}">{{ date('d-m-Y', strtotime($cashBalanceSession->createdDate))}}</a></td>
                                    <td>{{$cashBalanceSession->totalOpeningBalance}}</td>
                                    <td>{{$cashBalanceSession->totalClosingBalance}}</td>
                                    <td></td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: block">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Daily Cash Balance</h4>
                </div>

                <div class="modal-body">

                </div>


            </div>
        </div>
    </div>
    <style>
        .modal-dialog {
            width: 95%;
            max-width: 95%;
            height: 100%;
            padding: 0;
        }

        .modal-content {
            height: auto;
            min-height: 100%;
            border-radius: 0;
        }
    </style>
@endsection

@section('footer.scripts')
    {{--<script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#myModal").on("show.bs.modal", function(e) {
                var date = jQuery(e.relatedTarget).data('target-date');

                jQuery.get( "/cash/daily/session/quick/view?filter_date=" + date, function( data ) {
                    jQuery(".modal-body").html(data.html);
                });

            });

        });
    </script>--}}
@endsection