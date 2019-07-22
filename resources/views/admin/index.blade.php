{{--@extends('layouts.app')--}}
{{--@section('content')--}}
        <!DOCTYPE html>
<html lang="en">

<head>
    <title>Datta Able - HTML Documentation helper file</title>
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- meta -->
    <meta name="description" content="Datta Able bootstrap admin template documentation helper file." />
    <meta name="author" content="CodedThemes" />
    <!-- favicon -->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- required CSS -->
    <link rel="stylesheet" href="{{asset('/assets/fonts/fontawesome/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/animation/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/prism/css/prism.min.css')}}">
    <!-- custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <!-- internal CSS -->
    <style>
        .pcoded-navbar .pcoded-inner-navbar>li.active>a,
        .pcoded-navbar .pcoded-inner-navbar>li.pcoded-trigger>a {
            background: transparent;
        }

        .pcoded-navbar .pcoded-inner-navbar>li.active>a,
        .pcoded-navbar .pcoded-inner-navbar>li>a.active {
            background: #333f54;
            color: #fff;
            position: relative;
        }

        .pcoded-navbar .pcoded-inner-navbar>li.active>a,
        .pcoded-navbar .pcoded-inner-navbar>li>a.active>.pcoded-micon {
            color: #fff;
        }

        .pcoded-navbar .pcoded-inner-navbar>li>a.active:after {
            content: "";
            background-color: #1dc4e9;
            z-index: 1027;
            position: absolute;
            left: 0;
            top: 0px;
            width: 3px;
            height: 100%;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            background: #04a9f5;
            box-shadow: none;
        }

        pre[class*=language-]>code {
            border-left: 5px solid #04a9f5;
        }

        .nav-pills>li i {
            display: inline-block;
            font-size: 15px;
            padding: 0px 0;
        }
    </style>
</head>

<body>





<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="index.html">
                <img class="img-fluid" src="{{asset('assets/images/logo.png')}}" alt="Datta Able Logo" />
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item pcoded-menu-caption">
                    <label>Getting started</label>
                </li>
                 <li class="nav-item"><a href="{{route('project')}}" class="nav-link active"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Project</span></a></li>
                <li class="nav-item"><a href="{{route('comp_profile')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-navigation"></i></span><span class="pcoded-mtext">company Profile</span></a></li>
                <li class="nav-item"><a href="{{route('payment')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-cc-amex"></i></span><span class="pcoded-mtext">Payment</span></a></li>
                <li class="nav-item"><a href="{{route('setting')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-navigation"></i></span><span class="pcoded-mtext">Settings Table</span></a></li>
                <li class="nav-item"><a href="{{route('usertype')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-navigation"></i></span><span class="pcoded-mtext">User Type</span></a></li>

                <li class="nav-item"><a href="{{route('comp_create')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-navigation"></i></span><span class="pcoded-mtext">create company profile</span></a></li>




                <li class="nav-item pcoded-menu-caption">
                    <label>Create Information</label>
                </li>

                <li class="nav-item"><a href="{{route('project_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">create Project Table</span></a></li>

                <li class="nav-item"><a href="{{route('setting_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">create Setting Table</span></a></li>
                <li class="nav-item"><a href="{{route('payment_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">create Payment Table</span></a></li>
                <li class="nav-item"><a href="{{route('usertype_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">create UserType</span></a></li>

               

                {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" class="nav-link"><span class="pcoded-micon"><i class="fal fa-sign-out-alt"></i>Logout</span>--}}
                    {{--{{ csrf_field() }}--}}
                {{--</form>--}}


            </ul>
        </div>
    </div>
</nav>


<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
        <a href="index.html">
            <img class="img-fluid" src="{{asset('assets/images/logo-docs.png')}}" alt="Datta Able Logo" />
        </a>

    </div>
    <a class="mobile-menu" id="mobile-header" href="javascript:">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li><a href="javascript:" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li>
        </ul>
        <ul class="navbar-nav ml-auto">


        </ul>


    </div>
</header>


<div class="pcoded-main-container" id="home">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">

                    <div class="page-wrapper">
                        <div class="row">
                            @yield('template')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- required JS -->
    <script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/pcoded.min.js')}}"></script>
    <script src="{{asset('assets/plugins/prism/js/prism.min.js')}}"></script>
    <!-- custom JS -->
    <script type="text/javascript">
        $('body').scrollspy({
            target: ".pcoded-inner-navbar"
        });
        $('body').scroll(function() {
            $('.nav-item').removeClass('pcoded-trigger');
        });
        $(".pcoded-inner-navbar a").on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 1500, function() {
                    window.location.hash = hash;
                });
            }
        });
    </script>


</body>


</html>

{{--@endsection--}}
