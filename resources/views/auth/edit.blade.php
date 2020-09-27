@extends('layout')
@section('title','User Update')
@section('header.styles')
    {!! Html::style('/assets/css/multi-select.css') !!}
@endsection
@section('template')

 <div class="col-sm-12">
     <div class="card">
        <div class="card-header">
             <h5>Log In Component</h5>
            <div class="card-header-right">
                <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                    <a href="{{route('users.index')}}" class="btn btn-sm  btn-info"><i class="fas fa-angle-double-left"></i> Back</a>
                </div>
            </div>
        </div>

            <form class="form-horizontal" method="POST" action="{{ route('userprofileUpdate',$users->id) }}">

                <div class="card-body">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="control-label">UserName</label>
                                <input id="username" type="text" class="form-control" name="username" value="{{$users->username}}"  required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                               <strong>{{ $errors->first('username') }}</strong>
                               </span>
                                @endif

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">E-Mail Address</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{$users->email}}" required >

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                                @endif

                            </div>
                        </div>


                        {{--<div class="col-md-6">--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="exampleFormControlSelect1">Employe type</label>--}}

                                {{--<select class="form-control" name="user_types_id">--}}
                                    {{--<option value=""> Type </option>--}}
                                    {{--@foreach($usertypes as $usertype)--}}
                                        {{--<option value="{{$usertype->id}}" {{$usertype->id==$users->user_types_id?'selected="selected"':''}}>{{$usertype->u_title}} </option>--}}
                                    {{--@endforeach--}}

                                {{--</select>--}}

                            {{--</div>--}}
                        {{--</div>--}}

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_project">Project</label>

                                {{ Form::select('user_projects[]', array_pluck($projects,'p_name','id'), array_pluck($users->projects,'id'), ['class' => 'form-control multi_select','multiple']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Roles</label>
                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control multi_select','multiple')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">

                    <div class="col-md-12">
                        {{--<div class="card-header">--}}
                            <h5>Profile</h5>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="fname" placeholder="First Name" value="{{$users->UserProfile->fname}}">
                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="lname" placeholder="Last Name" value="{{$users->UserProfile->lname}}" >
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Select company</label>
                                    <select class="form-control" name="company_id" >
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}" {{$users->UserProfile->company_id==$company->id?'selected="selected"':''}} > {{$company->name}} </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="number" class="form-control" name="mobile" placeholder="Mobile Number" value="{{$users->UserProfile->mobile}}" >
                                </div>
                            </div>

                        </div>

                        <div class="line aligncenter" style="float: right">
                            <div class="form-group row">
                                <div style="padding-right: 3px" class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                    <button style="margin-right: 0" type="submit" class="btn btn-info"> <i class="feather icon-save"></i> Save</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    </div>

                </div>

            </form>
        </div>
        <!-- Input group -->

    </div>
@endsection

@section('footer.scripts')
    {!! Html::script('/assets/js/jquery.multi-select.js') !!}

    <script type="text/javascript">
        jQuery('.multi_select').multiSelect();
    </script>
@endsection