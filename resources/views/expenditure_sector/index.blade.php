@extends('layout')
@section('title','Expenditure Sector')
@section('template')


 <div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
       <div class="card">
          <div class="card-header">
              <h5>Expenditure Sector </h5>
              <div class="card-header-right">
                  @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('expenditure-sector-create'))
                  <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested">
                      <a href="{{route('expenditure_sector_create')}}" class="btn btn-sm  btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
                  </div>
                  @endif
              </div>

                </div>
      <div class="card-body">
         <table class= "table table-bordered">
             <thead class="thead-dark">

               <tr>
                   <th>SL</th>
                   <th>Name</th>
                   <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                            <i class="feather icon-settings"></i>
                   </th>
               </tr>
             </thead>
                @php $i=0; @endphp
                @foreach($expenditureSectors as $expenditure)
                 @php $i++ @endphp
                 <tr>
                        <td>{{$i}}</td>
                        {{--<td>{{$expenditure->id}} </td>--}}
                        <td>{{$expenditure->name}}</td>
                        <td>

                        <div class="btn-group card-option">

                            <a href="javascript:" class="btn btn-notify btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>

                           <ul class="list-unstyled card-option dropdown-info dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(34px, 29px, 0px);">
                               @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('expenditure-sector-edit'))
                               <li class="dropdown-item">
                                   <a href="{{route('expenditure_sector_edit',$expenditure)}}">
                                       <i class="feather icon-edit"></i> Edit
                                   </a>
                               </li>
                               @endif
                               @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('expenditure-sector-delete'))
                               <li class="dropdown-item">
                                   <a onclick="return confirm('Are you sure want to delete?')" href="{{route('expenditure_sector_delete',$expenditure->id)}}">
                                       <i class="feather icon-trash-2"></i> Remove
                                   </a>
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