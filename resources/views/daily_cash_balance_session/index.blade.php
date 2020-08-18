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
                                    <td>{{ date('d-m-Y', strtotime($cashBalanceSession->createdDate))}}</td>
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
@endsection