@extends('admin.index')
@section('template')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<style>
    .custom-select, .form-control {
        background: #f4f7fa;
        padding: 3px 0px;
        font-size: 13px;
    }

</style>

 <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Advance Payment  Reports</h5>
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



                    <div class="container box">
                        <h3 align="center"></h3><br/>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    {{--<div class="col-md-3">Date Range<b><span id="total_records"></span></b></div>--}}
                                    <div class="col-md-5">
                                        <div class="input-group input-daterange">
                                            <input type="text" name="from_date" id="from_date" readonly class="form-control" placeholder="From Date" />
                                            <div class="input-group-addon">To</div>
                                            <input type="text"  name="to_date" id="to_date" readonly class="form-control" placeholder="To Date" />

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" name="filter" id="filter" class="btn btn-info btn-sm">Search</button>
                                        <button type="button" name="refresh" id="refresh" class="btn btn-warning btn-sm">Refresh</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card-body">
                        <table class="table table-striped table-bordered dataTable no-footer">
                            <thead class="thead-dark">
                            <tr>
                                @foreach($projects as $project )
                                    <th>{{$project->p_name}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @foreach($projects as $project )
                                    <td style="vertical-align: text-top">
                                        @if(array_key_exists($project->id, $paymentDetails))
                                            <table class="table table-bordered">
                                                @foreach($paymentDetails[$project->id] as $paymentDetail)
                                                    <tr>
                                                        <td>
                                                            {{$paymentDetail}}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </table>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
 <script type="text/javascript">

    $(document).ready(function(){

        var date = new Date();

        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        var _token = $('input[name="_token"]').val();


        function payment_details_filter_by_date(from_date , to_date )
        {
            if (from_date==''){
                return false;
            }
            if (to_date==''){
                return false;
            }
            $.ajax({
                url:"{{ route('daterange.fetch_data') }}",
                method:"POST",
                data:{from_date:from_date, to_date: to_date, _token:_token},
                dataType:"html",
                success:function(data)
                {
                    $('tbody').html(data);
                }
            })
        }

        $('#filter').click(function(){
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if(from_date != '' &&  to_date != '')
            {
                payment_details_filter_by_date(from_date, to_date);
            }



            else
            {
                alert('Both Date is required');
            }
        });


        $('#refresh').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            payment_details_filter_by_date();
        });


    });



</script>
@endsection