

<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>

    <meta charset="utf-8">


    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('asset(/images/favicon.ico')}}" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome/css/fontawesome-all.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/plugins/animation/css/animate.min.css')}}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

</head>

<body>
<div class="auth-wrapper">
    <div class="auth-content">
        <div class="auth-bg">
            <span class="r"></span>
            <span class="r s"></span>
            <span class="r s"></span>
            <span class="r"></span>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}


                    <div class="mb-4">
                        <i class="feather icon-unlock auth-icon"></i>
                    </div>
                    <h3 class="mb-4">Login</h3>

                    <div class="input-group mb-3{{ $errors->has('username') ? ' has-error' : '' }}">
                        {{--  <label for="username" class="col-md-4 control-label">UserName</label> --}}

                        <div class="input-group mb-3">
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="UserName">

                            @if ($errors->has('username'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="input-group mb-4{{ $errors->has('password') ? ' has-error' : '' }}">



                        <input id="password" type="password" placeholder="password" class="form-control" name="password" required >

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif

                    </div>


                    <div class="form-group text-left">
                        <div class="checkbox checkbox-fill d-inline">
                            <input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="">
                            <label for="checkbox-fill-a1" class="cr"> Save Details</label>
                        </div>
                    </div>
                    <button class="btn btn-primary shadow-2 mb-4">Login</button>

                    <p class="mb-2 text-muted">Forgot password? <a href="auth-reset-password.html">Reset</a></p>


                    <p class="mb-0 text-muted">Don’t have an account? <a href="auth-signup.html">Signup</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Required Js -->
<script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

</body>
</html>