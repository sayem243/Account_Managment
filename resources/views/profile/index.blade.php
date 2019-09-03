@extends('admin.index')

@section('template')

    <div class="card">
        <div class="card-Header" align="center">
            Profile
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>SL</th>

                    {{--<th>Name</th>--}}
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Name</th>
                    <th>Mobile Number</th>
                    <th>Father Name</th>
                    <th>Mother Name</th>
                    <th>Joining Date</th>
                    <th>Present Address</th>
                    <th>Permanent Address</th>
                    <th>Company</th>


                    <th>National ID</th>

                </tr>
                </thead>

                <tbody>
                @php $i=0; @endphp

                @foreach( $profiles as $profile )

                    @php $i++ @endphp

                    <tr>
                        <td>{{$i}}</td>


                        {{--<td> {{ $profile->user['name']}}</td>--}}
                        <td> {{ $profile->fname }}</td>
                        <td> {{ $profile->lname }}</td>
                        <td> {{ $profile->email }}</td>
                        <td> {{ $profile->mobile }}</td>
                        <td> {{ $profile->fathername }}</td>
                        <td> {{ $profile->mothername }}</td>
                        <td>  {{$profile->joindate}}</td>
                        <td> {{ $profile->p_address }}</td>
                        <td> {{ $profile->address}} </td>
                        <td> {{ $profile->company['name'] }} </td>
                        <td> {{ $profile->nid }} </td>



                    </tr>



                    @endforeach


                </tbody>




            </table>




        </div>


    </div>



    @endsection