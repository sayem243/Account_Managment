@extends('admin.index')
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
                <strong>Name:</strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permission:</strong>
                <br/>
                @foreach($permission as $value)
                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                        {{ $value->name }}</label>
                    <br/>
                @endforeach
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
            <button type="submit" class="btn btn-info">Submit</button>
        </div>
    </div>
  </div>
    {!! Form::close() !!}
                    <p class="text-center text-primary"><small>Right Brain Solution Limited.All Rights Reserved</small></p>
                </div>
            </div>
        </div>
    </div>


@endsection
