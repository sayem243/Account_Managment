@extends('admin.index')
@section('template')

 <div class="col-sm-12">
     <div class="card">
        <div class="card-header">
             <h5>Log In Componant</h5></div>

            <form class="form-horizontal" method="POST" action="{{ route('userprofileUpdate',$user->id) }}">

                <div class="card-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="control-label">UserName</label>
                                <input id="username" type="text" class="form-control" name="username" value="{{$user->username}}"  required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                               <strong>{{ $errors->first('username') }}</strong>
                               </span>
                                @endif

                            </div>



                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">E-Mail Address</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}" required >

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                                @endif

                            </div>



                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="control-label">Password</label>

                                <input id="password" type="password" class="form-control" name="password" value="{{$user->password}}" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="control-label">Confirm Password</label>

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  required>
                            </div>

                            <div class="form-group">
                                <label for="user_project">select Project</label>
                                <select class="form-control" name="user_projects[]" multiple >
                                    <option value="">Select Project</option>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}"> {{$project->p_name}} </option>
                                    @endforeach
                                </select>
                            </div>




                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Text" value="{{$user->name}}" >
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Employe type</label>

                                <select class="form-control" name="user_types_id">
                                    <option value=""> Type </option>
                                    @foreach($usertypes as $usertype)
                                        <option value="{{$usertype->id}}"> {{$usertype->u_title}} </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select company</label>
                                <select class="form-control" name="company_id" multiple>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}"> {{$company->name}} </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group">
                                <strong>Role:</strong>
                                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
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
                                    <input type="text" class="form-control" name="fname" placeholder="First Name" value="{{$user->UserProfile->fname}}">
                                </div>

                                <div class="form-group">
                                    <label>Fathers Name</label>
                                    <input type="text" class="form-control" name="fathername" placeholder="Fathers Name" value="{{$user->UserProfile->fathername}}" >
                                </div>



                                <div class="form-group">
                                    <label>Present Address</label>
                                    <input type="text" class="form-control" name="p_address" placeholder="Present Address" value="{{$user->UserProfile->p_address}}">
                                </div>

                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="number" class="form-control" name="mobile" placeholder="Mobile Number" value="{{$user->UserProfile->mobile}}" >
                                </div>



                                <div class="form-group">
                                    <label>NID</label>
                                    <input type="number" class="form-control" name="nid" placeholder="National ID" value="{{$user->UserProfile->nid}}">
                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="lname" placeholder="Last Name" value="{{$user->UserProfile->lname}}" >
                                </div>



                                <div class="form-group">
                                    <label>Mothers Name</label>
                                    <input type="text" class="form-control" name="mothername" placeholder="Mothers Name" value="{{$user->UserProfile->mothername}}">
                                </div>

                                <div class="form-group">
                                    <label>Permanent Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Permanent Address"  value="{{$user->UserProfile->address}}">
                                </div>

                                <div class="form-group">
                                    <label>Joining Date</label>
                                    <input type="date" class="form-control" name="joindate" placeholder="Joining Date" value="{{$user->UserProfile->joindate}}">
                                </div>


                            </div>

                            <div class="col-sm-12 col-form-label" align="right">
                                <button type="submit" class="btn btn-primary" >Submit</button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>
        </div>
        <!-- Input group -->

    </div>
@endsection
