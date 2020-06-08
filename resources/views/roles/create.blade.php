@extends('admin.index')
@section('title','Role Add')
@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
    <div class="card-header">
        <h5>New Role</h5>
        <div class="card-header-right">
            <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                <a href="{{route('roles.index')}}" class="btn btn-sm  btn-info">Back</a>
            </div>
            <div class="btn-group card-option">
                <button type="button" class="btn dropdown-toggle btn-more" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-original-title="" title="">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                    <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                    <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                    <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>

                </ul>
            </div>
        </div>
    </div>

    <div class="card-body">
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


    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
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
                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                        {{ $value->name }}</label>
                    <br/>
                @endforeach

            </div>
        </div>
        <div class="col-sm-12 col-form-label" align="right">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}

    </div>
                </div>
            </div>
        </div>
    </div>

@endsection