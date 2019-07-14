@extends('layout.Master')

@section('content')
    <div class="container">
        <h2>Settings Table </h2>
        <p>Settings Table define Employee status </p>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>serial</th>
                <th>Employee Typee</th>
                <th>Employee Designation</th>
            </tr>
            </thead>
            <tbody>

            @php $i=0; @endphp
            @foreach($settings as $setting)
                @php $i++ @endphp

            <tr>
                <td>{{$i}}</td>
                <td>{{$setting->empl_type}}</td>
                <td>{{$setting->des_id}}</td>
            </tr>

            @endforeach
            </tbody>
        </table>
    </div>


@endsection