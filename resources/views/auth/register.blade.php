@extends('layout')
@section('header.styles')
    {!! Html::style('/assets/css/multi-select.css') !!}
@endsection
@section('title','User Add')
@section('template')

    <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Log In Componant</h5>
                    <div class="card-header-right">
                        <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                            <a href="{{route('users.index')}}" class="btn btn-sm  btn-info"><i class="fas fa-angle-double-left"></i> Back</a>
                        </div>
                    </div>
                </div>

                <form class="form-horizontal" method="POST" action="{{ route('store') }}">

                    <div class="card-body">
                            {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username" class="control-label">UserName</label>
                                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                                                <strong>{{ $errors->first('username') }}</strong>
                                                                </span>
                                    @endif

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">Password</label>

                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">Confirm Password</label>

                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{--<div class="col md 6">--}}


                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="control-label">E-Mail Address</label>

                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                                             </span>
                                        @endif

                                    </div>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label for="exampleFormControlSelect1">Employe type</label>--}}

                                    {{--<select class="form-control" name="user_types_id">--}}
                                        {{--<option value=""> Type </option>--}}
                                        {{--@foreach($usertypes as $usertype)--}}
                                            {{--<option value="{{$usertype->id}}"> {{$usertype->u_title}} </option>--}}
                                        {{--@endforeach--}}

                                    {{--</select>--}}

                                {{--</div>--}}

                            <div class="col md 6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Select company</label>
                                    <select class="form-control" name="company_id" required>
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}"> {{$company->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md 6">
                                <div class="form-group">
                                    <label for="user_project">Select Project</label>
                                    <select class="form-control multi_select" name="user_projects[]" multiple>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}"> {{$project->p_name}} </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col md 6">
                                <div class="form-group">
                                    <label for="roles">Role</label>
                                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control multi_select','multiple')) !!}
                                </div>
                            </div>
                        </div>

                    <div class="col-md-12">
                        <div class="card-header">
                            <h5>Profile</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="fname" placeholder="First Name" required>
                                </div>

                                {{--<div class="form-group">--}}
                                    {{--<label>Fathers Name</label>--}}
                                    {{--<input type="text" class="form-control" name="fathername" placeholder="Fathers Name">--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label>Present Address</label>--}}
                                    {{--<input type="text" class="form-control" name="p_address" placeholder="Present Address">--}}
                                {{--</div>--}}

                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="number" class="form-control" name="mobile" placeholder="Mobile Number">
                                </div>

                                {{--<div class="form-group">--}}
                                    {{--<label>NID</label>--}}
                                    {{--<input type="number" class="form-control" name="nid" placeholder="National ID ">--}}
                                {{--</div>--}}

                            </div>


                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="lname" placeholder="Last Name">
                                </div>

                                {{--<div class="form-group">--}}
                                    {{--<label>Mothers Name</label>--}}
                                    {{--<input type="text" class="form-control" name="mothername" placeholder="Mothers Name">--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label>Permanent Address</label>--}}
                                    {{--<input type="text" class="form-control" name="address" placeholder="Permanent Address">--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label>Joining Date</label>--}}
                                    {{--<input type="date" class="form-control" name="joindate" placeholder="Joining Date">--}}
                                {{--</div>--}}


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
