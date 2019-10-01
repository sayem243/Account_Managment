@extends('admin.index-pdf')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Voucher Details</h5>

                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Payment Date: </label>
                                    {{date('d-m-Y',strtotime($details->created_at))}}
                                </div>
                                <div class="form-group">
                                    <label for="">Company: </label>
                                    {{$details->user->userProfile->company['name']}}
                                </div>
                                <div class="form-group">
                                    <label for="">NID: </label>
                                    {{$details->user->userProfile['nid'] }}
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Employe Name: </label>
                                    {{$details->user['name'] }}
                                    {{$details->user->UserProfile['fname'].' '.$details->user->UserProfile['lname']}}

                                </div>

                                <div class="form-group">
                                    <label for="">Mobile Number: </label>
                                    {{$details->user->userProfile['mobile'] }}
                                </div>


                            </div>
                        </div>

                        <div class="col-md-12">
                            <h4 align="center"><em>Voucher Details </em>  </h4>
                        </div>

                        <table class= "table table-bordered" id="voucher">
                            <thead class="thead-dark">
                            <tr>
                                <th>Serial</th>
                                <th>Payment ID</th>
                                <th>Project</th>
                                <th>Received</th>
                                <th>Date</th>


                            </tr>
                            </thead>

                            @php $i=0; @endphp
                            @foreach($details->vocher_details as $detail)
                                @php $i++ @endphp

                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$detail->payment->payment_id}}</td>
                                    <td>{{$detail->project['p_name']}}</td>

                                    <td>{{$detail->amount}}</td>
                                    <td>{{date('d-m-y',strtotime($detail->created_at))}}</td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
      window.print();
    </script>




@endsection