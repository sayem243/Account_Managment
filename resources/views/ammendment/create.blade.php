@extends('admin.index')
@section('template')
 <div class="col-sm-12">
     <div class="card" id="references">
       <div class="card-header">
          <h3> Amendment</h3></div>
          <div class="card-body">
              <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="exampleInputEmail1">Employe Name: </label>
                      {{$payment->user->UserProfile['fname'].' '.$payment->user->UserProfile['lname']}}
                  </div>
                  <div class="form-group">
                      <label for="nid"> Advance Payment ID: </label>
                      {{$payment->payment_id }}
                  </div>
              </div>
              </div>
                <form class="form-horizontal" action="{{ route('amendment_store',$payment->id)}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th>SL</th>
                            <th>Projects</th>
                            <th>Demand(BDT) </th>
                            <th>Paid(BDT)</th>
                            <th>Amendment</th>
                        </tr>
                        </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach($payment->Payment_details as $detail )
                                @php
                                    $i++ ;
                                @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$detail->project['p_name']}}</td>
                                    <td>{{$detail->demand_amount}}</td>
                                    <td>{{$detail->paid_amount}}</td>
                                    <td>
                                        <input type="hidden" name="project_id[]" value="{{$detail->project['id']}}">
                                        <input type="text" name="amendment_amount[]" class="form-control">
                                    </td>
                                </tr>
                            @endforeach

                            {{--<tr>--}}
                                {{--<td colspan="10">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<div class="col-sm-offset-2 col-sm-12" align="right">--}}
                                            {{--<button type="submit" class="btn btn-primary">Save </button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}

                            </tbody>
                    </table>
                        <div class="form-group row">
                        <label for="file" class="col-sm-4 col-form-label">File :</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="file" id="file" placeholder="">
                        </div>
                        </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-12" align="right">
                            <button type="submit" class="btn btn-primary">Save </button>
                        </div>
                    </div>
                </form>
          </div>
        </div>
    </div>
@endsection
