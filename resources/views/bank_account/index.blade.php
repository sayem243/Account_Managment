@extends('layout')
@section('title','Bank List')
@section('template')


 <div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
       <div class="card">
          <div class="card-header">
              <h5>Bank </h5>
              <div class="card-header-right">
                  @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('superadmin'))
                  <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested">
                      <a href="{{route('account_create')}}" class="btn btn-sm  btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
                  </div>
                  @endif
              </div>

                </div>
      <div class="card-body">
         <table class= "table table-bordered">
             <thead class="thead-dark">

               <tr>
                   <th style="width: 5%">SL</th>
                   <th style="width: 90%">Name</th>
                   <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 5%;">
                            <i class="feather icon-settings"></i>
                   </th>
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
{{--    <script src="{{ asset("assets/datatable/bank.js") }}" ></script>--}}
@endsection