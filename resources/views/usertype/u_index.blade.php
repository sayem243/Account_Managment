@extends('layout.Master')

@section('content')



    <div class="container">
        <h2> User Type </h2>
        <p>  </p>
        <table class="table table-bordered">
            <thead>
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



@endsection