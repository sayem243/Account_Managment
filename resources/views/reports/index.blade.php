@extends('admin.index')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Reports</h5>
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
                    <div class="card-body">
                        <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="">Select Date: </label>
                                 <?php

                                 ?>

                                   <input type="date" class="">
                             </div>
                         </div>
                      </div>
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



@endsection