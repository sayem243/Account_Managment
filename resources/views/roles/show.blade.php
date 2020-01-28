@extends('admin.index')
@section('template')
<div class="col-sm-12">
 <div class="row">
  <div class="col-sm-12">
    <div class="card">
     <div class="card-header">
        <h5>Show Role</h5>
        <div class="card-header-right">
            <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                <a href="{{ route('roles.index') }}" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i>Back</a>
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
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <b>Name:</b>
               <b>{{ $role->name }}</b>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permissions:</strong>
                @if(!empty($rolePermissions))
                    @foreach($rolePermissions as $v)
                        <label class="label label-success">{{ $v->name }},</label>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    </div>


                </div>
            </div>
        </div>
    </div>
@endsection