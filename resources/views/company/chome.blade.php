@extends('admin.index')

@section('template')


 <div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
       <div class="card">
          <div class="card-header">
              <h5>Company Details </h5>
              <div class="card-header-right">
                  <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested">
                      <a href="{{route('comp_create')}}" class="btn btn-sm  btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
                  </div>
              </div>

                </div>
      <div class="card-body">
         <table class= "table table-bordered">
             <thead class="thead-dark">
           <tr>
            <th>SL</th>
               {{--<th>ID</th>--}}
             <th>Name</th>
           <th>Email</th>
          <th>Mobile Number</th>
          <th>Address</th>

              <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                        <i class="feather icon-settings"></i>

                    </th>
                </tr>
                </thead>
                @php $i=0; @endphp
                @foreach($companys as $company)
                 @php $i++ @endphp
                 <tr>
                        <td>{{$i}}</td>
                        {{--<td>{{$company->id}} </td>--}}
                        <td>{{$company->name}}</td>
                        <td>{{$company->c_email}}</td>
                        <td>{{$company->c_mobile}}</td>
                        <td>{{$company->c_address}}</td>


                        <td>

                   <div class="btn-group card-option">

                        <a href="javascript:" class="btn btn-notify btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>

                       <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
                                    <li class="dropdown-item">
                                        <a href="{{route('comp_edit',$company->id)}}">
                                            <i class="feather icon-edit"></i>
                                            Edit</a>
                                    </li>

                                    <li class="dropdown-item">
                                        <a href="{{route('com_delete',$company->id)}}">
                                            <i class="feather icon-trash-2"></i>
                                            Remove</a>
                                    </li>

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