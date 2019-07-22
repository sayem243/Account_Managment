{{--@extends('layout.Master')--}}
@extends('admin.index')

{{--@section('content')--}}

    @section('template')
        <div class="col-sm-12">
            <div class="card" id="references">
                <div class="card-header">



    <div class="text-center"><h2> Project Details </h2>

        <div class="table-responsive-lg">
            <table class= "table table-hover">
                <tr>
                    <th>Serial</th>

                    <th>Project   Name</th>
                    <th>Project Tittle </th>

                    <th>Company Involved</th>
                </tr>
                @php $i=0; @endphp


                @foreach($projects as $project)

                    @php $i++ @endphp

                    <tr>
                        <td>{{$i}}</td>

                        <td>{{$project->p_name}} </td>
                        <td>{{$project->p_title}}</td>

                        <td>{{$project->company['name']}}</td>

                    </tr>




                @endforeach

            </table>
        </div>

    </div>

                </div>
            </div>
        </div>

    @endsection

        {{--@endsection--}}
