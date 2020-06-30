@extends('layout')
@section('title','Voucher Items List')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Voucher Items List</h5>
                    </div>
                    <div class="card-body voucher_item_table payment_table">

                        <form class="form-horizontal" action="{{ route('voucher_store')}}" method="post">
                            {{ csrf_field() }}
                            <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                                <thead class="thead-dark">
                                <tr role="row" class="filter">
                                    <td colspan="2">
                                        <input  type="text" class="form-control form-filter input-sm" name="payment_id" id="payment_id" placeholder="Payment Id"> </td>

                                    </td>
                                    <td>
                                        <select class="form-control" name="project_id" id="project_id">
                                            <option value="">All Project</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->p_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td colspan="4"></td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle;" scope="col"><input type="checkbox" class="form-control all_item"></th>
                                    <th style="width: 200px" scope="col">Expenses Type</th>
                                    <th style="width: 350px" scope="col">Item Name</th>
                                    <th style="width: 120px" width="" scope="col">HS ID</th>
                                    <th style="width: 150px" width="" scope="col">Project</th>
                                    <th style="width: 100px" width="" scope="col">Amount</th>
                                </tr>

                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="line aligncenter" style="float: right">
                                <div class="form-group row">
                                    <div style="padding-right: 3px" class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                        <button onclick="return confirm('Are you sure?')" style="margin-right: 0" type="submit" class="btn btn-info btn-lg voucher_add_button" data-original-title="" title="">Next <i class="fas fa-angle-double-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer.scripts')
    <script src="{{ asset("assets/datatable/voucher-details.js") }}" ></script>
@endsection

