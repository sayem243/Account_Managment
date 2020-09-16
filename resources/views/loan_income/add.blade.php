@extends('layout')
@section('title','Add Loan & Income')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Loan & Income</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-lg" role="group"
                                 aria-label="Button group with nested dropdown">

                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card tab-card" style="margin-bottom: 0px">
                                    <div class="card-header tab-card-header" style="padding-bottom: 0; padding-left: 10px">
                                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="check-tab" data-toggle="tab" href="#check" role="tab" aria-controls="One" aria-selected="true">Check</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="Two" aria-selected="false">Cash</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div style="padding: 0px" class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="check" role="tabpanel" aria-labelledby="check-tab">
                                            <div class="card tab-card" style="margin-bottom: 0px">
                                                <div class="card-header tab-card-header" style="padding-bottom: 0; padding-left: 10px">
                                                    <ul class="nav nav-tabs card-header-tabs" id="myTab1" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="check-loan-tab" data-toggle="tab" href="#check_loan" role="tab" aria-controls="Loan" aria-selected="true">Loan</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="check-income-tab" data-toggle="tab" href="#check_income" role="tab" aria-controls="Income" aria-selected="false">Income</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="check-expense-tab" data-toggle="tab" href="#check_expense" role="tab" aria-controls="Expense" aria-selected="false">Expense</a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div style="padding: 0 5px" class="tab-content" id="myTabContent1">
                                                    <div class="tab-pane fade show active p-3" id="check_loan" role="tabpanel" aria-labelledby="check-loan-tab">

                                                        @include('loan_income._content_check_loan')

                                                    </div>
                                                    <div class="tab-pane fade p-3" id="check_income" role="tabpanel" aria-labelledby="check-income-tab">

                                                        @include('loan_income._content_check_income')

                                                    </div>
                                                    <div class="tab-pane fade p-3" id="check_expense" role="tabpanel" aria-labelledby="check-expense-tab">

                                                        @include('loan_income._content_check_expense')

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="cash" role="tabpanel" aria-labelledby="cash-tab">
                                            <div class="card tab-card" style="margin-bottom: 0px">
                                                <div class="card-header tab-card-header" style="padding-bottom: 0; padding-left: 10px">
                                                    <ul class="nav nav-tabs card-header-tabs" id="myTabCash" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="cash-loan-tab" data-toggle="tab" href="#cash_loan" role="tab" aria-controls="Loan" aria-selected="true">Loan</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="cash-income-tab" data-toggle="tab" href="#cash_income" role="tab" aria-controls="Income" aria-selected="false">Income</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="cash-expense-tab" data-toggle="tab" href="#cash_expense" role="tab" aria-controls="Expense" aria-selected="false">Expense</a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div style="padding: 0 5px" class="tab-content" id="myTabContent2">
                                                    <div class="tab-pane fade show active p-3" id="cash_loan" role="tabpanel" aria-labelledby="cash-loan-tab">

                                                        @include('loan_income._content_cash_loan')

                                                    </div>
                                                    <div class="tab-pane fade p-3" id="cash_income" role="tabpanel" aria-labelledby="cash-income-tab">

                                                        @include('loan_income._content_cash_income')

                                                    </div>
                                                    <div class="tab-pane fade p-3" id="cash_expense" role="tabpanel" aria-labelledby="cash-expense-tab">

                                                        @include('loan_income._content_cash_expense')

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <style>
        fieldset {
            min-width: 0;
            padding: 5px 10px;
            margin: 0;
            border: 1px solid #000;
        }
        legend {
            display: block;
            width: auto;
            max-width: 100%;
            padding: 0px 10px;
            margin-bottom: .5rem;
            font-size: 1.5rem;
            line-height: inherit;
            color: inherit;
            white-space: normal;
            border: 1px solid #000;
            border-radius: 10px;
        }
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
            border: none;
            color: #fff;
            -webkit-box-shadow: 0 -3px 10px 0 rgba(0, 0, 0, 0.05);
            box-shadow: 0 -3px 10px 0 rgba(0, 0, 0, 0.05);
            background-color: blue;
        }
    </style>

@endsection
@section('footer.scripts')
    <script src="{{ asset("assets/js/loan.js") }}" ></script>
    <script src="{{ asset("assets/js/loan-cash.js") }}" ></script>
    <script src="{{ asset("assets/js/income.js") }}" ></script>
    <script src="{{ asset("assets/js/income-cash.js") }}" ></script>
    <script src="{{ asset("assets/js/expense.js") }}" ></script>
@endsection
