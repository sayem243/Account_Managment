@extends('layout')
@section('title','Role Update')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

    <div class="card-header">
        <h5>Role Edit</h5>
        <div class="card-header-right">
            <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                <a href="{{route('roles.index')}}" class="btn btn-sm  btn-info"><i class="fas fa-angle-double-left"></i> Back</a>
            </div>
        </div>
    </div>



    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
     <div class="card-body">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4>Name:</h4>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
        </div>


        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

<div class="row ">
                <div class="col-md-6">
                <h5>Permission: </h5>
                </div>
                <div class="col-md-6">
                <h5>Description: </h5>
                </div>
</div>

            </br>
                <div class="row">
                @foreach($permission as $value)
                    <div class="col-md-6">
                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                        {{ $value->name }}</label></div>
<div class="col-md-6">
                    <label>
                        {{ $value->description }}
                    </label>
</div>

            </br>


                @endforeach

</div>
            </div>
        </div>
    </div>
         <div class="line aligncenter" style="float: right">
             <div class="form-group row">
                 <div class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                     <button style="margin-right: 0" type="submit" class="btn btn-info"> <i class="feather icon-save"></i> Save</button>
                     {{--<button type="reset" class="btn btn btn-outline-danger" data-original-title="" title=""> <i class="feather icon-refresh-ccw"></i> Cancel</button>--}}
                 </div>
             </div>
         </div>
  </div>
    {!! Form::close() !!}

                    {{--testing--}}

                    {{--<div class="container">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-12">--}}
                                {{--<table class="table table-bordered">--}}
                                    {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th scope="col">Permissions</th>--}}
                                        {{--<th scope="col">Description</th>--}}

                                    {{--</tr>--}}
                                    {{--</thead>--}}
                                    {{--<tbody>--}}
                                    {{--<tr>--}}
                                    {{--</br>--}}
                                        {{--@foreach($permission as $value)--}}
                                        {{--<td>--}}
                                            {{--<div class="custom-control custom-checkbox">--}}
                                                {{--<label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}--}}
                                                    {{--{{ $value->name }}</label>--}}
                                            {{--</div>--}}
                                        {{--</td>--}}
                                        {{--<td> {{ $value->description }}</td>--}}

                                       {{--@endforeach--}}
                                    {{--</br>--}}
                                    {{--</tr>--}}

                                    {{--</tbody>--}}
                                {{--</table>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}


                    {{--endtesting--}}





                    <p class="text-center text-primary"><small>Right Brain Solution Limited.All Rights Reserved</small></p>
                </div>
            </div>
        </div>
    </div>


@endsection
