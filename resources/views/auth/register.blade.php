@extends('admin.index')

@section('template')

    <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Basic Componant</h5>
                </div>

                <div class="card-body">


                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
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



                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">E-Mail Address</label>

                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                                             </span>
                                        @endif

                                </div>



                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">Password</label>

                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">Confirm Password</label>

                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                        </div>

                        <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Text">
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
                                    <label for="exampleFormControlSelect1">select company</label>
                                    <select class="form-control" name="company_id" multiple>
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}"> {{$company->name}} </option>
                                        @endforeach
                                    </select>

                                </div>



                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Role</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
                                </div>


                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </div>

                    </form>

                </div>

            </div>
            <!-- Input group -->

        </div>









@endsection
