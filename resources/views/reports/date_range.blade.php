<!DOCTYPE html>
<html>
<head>
    <title>Date Range Fiter Data in Laravel using Ajax</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />

</head>
<body>
<br />
<div class="container box">
    <h3 align="center"></h3><br />
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-5">Total Records - <b><span id="total_records"></span></b></div>
                <div class="col-md-5">
                    <div class="input-group input-daterange">
                        <input type="text" name="from_date" id="from_date" readonly class="form-control" />
                        <div class="input-group-addon">to</div>
                        <input type="text"  name="to_date" id="to_date" readonly class="form-control" />
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" name="filter" id="filter" class="btn btn-info btn-sm">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-warning btn-sm">Refresh</button>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered dataTable no-footer">
                    <thead class="thead-dark">
                    <tr>
                        @foreach($projects as $project )
                            <th>{{$project->id}}-{{$project->p_name}}</th>

                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($projects as $project )
                            <td style="vertical-align: text-top">
                                @if(array_key_exists($project->id, $paymentDetails))
                                    <table class="table table-bordered payment_report">
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

                {{ csrf_field() }}
            </div>
        </div>

    </div>
</div>
</body>
</html>

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

            else if(from_date != ''  || from_date != '' ){
                fetch_data_value(from_date);
            }

            else
            {
                alert('Both Date is required');
            }
        });


//editing

        {{--function payment_details_filter_by_date(from_date  )--}}
        {{--{--}}
            {{--if (from_date==''){--}}
                {{--return false;--}}
            {{--}--}}

            {{--$.ajax({--}}
                {{--url:"{{ route('daterange.fetch_data') }}",--}}
                {{--method:"POST",--}}
                {{--data:{from_date:from_date,  _token:_token},--}}
                {{--dataType:"html",--}}
                {{--success:function(data)--}}
                {{--{--}}
                    {{--$('tbody').html(data);--}}
                {{--}--}}
            {{--})--}}
        {{--}--}}


        $('#filter').click(function(){
            var from_date = $('#from_date').val();
            //var from_date = $('#from_date').val();
            if(from_date != '' &&  from_date != '')
            {
                fetch_data_value(from_date);
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
