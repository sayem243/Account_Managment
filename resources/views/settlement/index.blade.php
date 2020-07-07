@extends('layout')
@section('title','Payment Settlement List')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Payment Settlement</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered dataTable no-footer" id="payment_settlement_table">
                            <thead class="thead-dark">
                            <tr role="row" class="filter">
                                <td colspan="2">
                                    <select class="form-control" name="company_id" id="company_id" aria-describedby="validationTooltipPackagePrepend" required>
                                        <option value="">All Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td colspan="1">
                                    <select class="form-control" name="project_id" id="project_id">
                                        <option value="">All Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->p_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td colspan="1">
                                    From <input style="display: inline; width: auto;"  type="date" data-date="" data-date-format="DD-MM-YYYY" value="" class="form-control date_picker" name="from_date" id="from_date">
                                </td>
                                <td colspan="1">
                                    To <input style="display: inline; width: auto;" type="date" data-date="" data-date-format="DD-MM-YYYY" value="" class="form-control date_picker" name="to_date" id="to_date">
                                </td>
                            </tr>
                            <tr>
                                <th>SL</th>
                                <th>Payment ID</th>
                                <th>Company</th>
                                <th>Project</th>
                                <th>Amount(BDT)</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>

                    </div>
            </div>

            </div>
        </div>
    </div>

@endsection
@section('footer.scripts')
    <script src="{{ asset("assets/datatable/payment-settlement.js") }}" ></script>
@endsection
