@extends('layout')
@section('title','Client List')
@section('template')


 <div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
       <div class="card">
          <div class="card-header">
              <h5>Client List </h5>
              <div class="card-header-right">
                  <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested">
                      <a style="-webkit-transform: scale(0.9);" href="{{route('client_create')}}" class="btn btn-sm  btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
                  </div>
              </div>

                </div>
      <div class="card-body">
         <table class= "table table-bordered">
             <thead class="thead-dark">
           <tr>
            <th>SL</th>
             <th>Name</th>
          <th>Mobile Number</th>
          <th>Address</th>
          <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                    <i class="feather icon-settings"></i>

                </th>
                </tr>
                </thead>
                @php $i=0; @endphp
                @foreach($clients as $client)
                 @php $i++ @endphp
                 <tr style="{{$client->trashed()?'background-color: #ff4b47; color: #ffffff':''}}">
                        <td>{{$i}}</td>
                        <td>{{$client->name}}</td>
                        <td>{{$client->phone}}</td>
                        <td>{{$client->address}}</td>
                        <td>
                        <div class="btn-group card-option">

                        <a href="javascript:" class="btn btn-notify btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>

                             <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
                                    <li class="dropdown-item">
                                        <a href="{{route('client_edit',$client->id)}}">
                                            <i class="feather icon-edit"></i>
                                            Edit</a>
                                    </li>
                                @if(auth()->user()->hasRole('superadmin') && !$client->trashed())
                                    <li class="dropdown-item">
                                        <a onclick="return confirm('Are you sure want to delete?')" href="{{route('client_delete',$client->id)}}">
                                            <i class="feather icon-trash-2"></i>
                                            Remove</a>
                                    </li>
                                @endif
                               @if(auth()->user()->hasRole('superadmin') && $client->trashed())
                                   <li class="dropdown-item">
                                       <a href="{{route('client_restore',$client->id)}}">
                                           <i class="fa fa-undo" aria-hidden="true"></i>
                                           Restore</a>
                                   </li>
                               @endif

                                </ul>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </table>

                </div>





        </div>
    </div>

    </div>
    </div>
@endsection