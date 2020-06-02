@extends('admin.index')

@section('template')

    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">
                <h5>User Types List</h5>
                <div class="card-header-right">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                        <a href="{{route('usertype_create')}}" class="btn btn-sm  btn-info"><i class="fas fa-sign-out-alt"></i>Add New</a>
                    </div>
                </div>

            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">

                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th>serial</th>
                            <th> Tittle </th>
                        </tr>
                        </thead>


                        <tbody>

                        @php $i=0; @endphp

                        @foreach( $subtypes as $subtype)

                            @php $i++ @endphp

                            <tr>
                                <td>{{$i}}</td>
                                <td>
                                    {{$subtype->u_title}}
                                </td>
                            </tr>

                        @endforeach

                        </tbody>


                    </table>

            </div>
        </div>
    </div>

@endsection