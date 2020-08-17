@extends('layout')
@section('title','Dashboard')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Daily Opening Balance Start </h5>
                    </div>
                    <div class="card-body">

                        <form action="{{route('opening_balance_start')}}" method="post">
                            {{ csrf_field() }}
                            <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested">
                                <button name="generate" value="generate" type="submit" class="btn btn-sm  btn-info">Start</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection