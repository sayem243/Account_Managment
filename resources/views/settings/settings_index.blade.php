@extends('admin.index')

{{--@extends('layout.Master')--}}


{{--@section('content')--}}

@section('template')
    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">

    <div class="container">
        <h4>Settings Table </h4>

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
            </div>
        </div>
    </div>

@endsection

{{--@endsection--}}