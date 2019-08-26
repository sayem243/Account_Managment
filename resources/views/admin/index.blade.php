<!DOCTYPE html>
<html lang="en">

<head>
    <title>Datta Able Free Bootstrap 4 Admin Template</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Free Datta Able Admin Template come up with latest Bootstrap 4 framework with basic components, form elements and lots of pre-made layout options" />
    <meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, datta able, datta able bootstrap admin template, free admin theme, free dashboard template"/>
    <meta name="author" content="CodedThemes"/>

    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome/css/fontawesome-all.min.css')}}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/animation/css/animate.min.css')}}">
    <!-- vendor css -->

    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">


    {{--<link rel="stylesheet" href="{{asset('multi-select/0.9.12/css/multi-select.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('multi-select/0.9.12/css/multi-select.min.css')}}">--}}

    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        .btn-group-sm>.btn, .btn-sm {
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.2;
            border-radius: .2rem;
        }



    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->
<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="index.html" class="b-brand">
                <div class="logo">

                    {{--<img src="{{asset('assets/images/ems.png')}}" style="width: 100px" >--}}

                </div>
                <span class="b-title"></span>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>
        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: calc(100vh - 70px);">
        <div class="navbar-content scroll-div" style="overflow: hidden; width: 100%; height: calc(100vh - 70px);">
            <ul class="nav pcoded-inner-navbar">
                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item active">
                    <a href="{{route('admin_index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>

                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="fa fa-credit-card" style="color:green"></i></span><span class="pcoded-mtext">Payements</span></a>
                    <ul class="pcoded-submenu">

                        <li class="nav-item"><a href="{{route('payment')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-credit-card" aria-hidden="true"></i></span><span class="pcoded-mtext">Payment</span></a></li>
                        <li class="nav-item"><a href="{{route('payment_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-credit-card" aria-hidden="true"></i></span><span class="pcoded-mtext">Add Payment</span></a></li>

                        {{--<li class="nav-item"><a href="{{route('amendment')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-credit-card" aria-hidden="true"></i></span><span class="pcoded-mtext">Amendment</span></a></li>--}}

                    </ul>
                </li>

                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Company </span></a>
                    <ul class="pcoded-submenu">

                        <li class="nav-item"><a href="{{route('comp_profile')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-building" aria-hidden="true"></i></span><span class="pcoded-mtext">company Profile</span></a></li>
                        <li class="nav-item"><a href="{{route('comp_create')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-box"></i> </span><span class="pcoded-mtext"> New company</span></a></li>
                    </ul>

                </li>


                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Projects</span></a>
                    <ul class="pcoded-submenu">

                        <li class="nav-item"><a href="{{route('project')}}" class="nav-link active"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Project</span></a></li>
                        <li class="nav-item"><a href="{{route('project_create')}}" class="nav-link active"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Project Create</span></a></li>

                    </ul>

                </li>

                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">User Types</span></a>
                    <ul class="pcoded-submenu">

                        <li class="nav-item"><a href="{{route('usertype')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-navigation"></i></span><span class="pcoded-mtext">User Type</span></a></li>
                        <li class="nav-item"><a href="{{route('usertype_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">create UserType</span></a></li>
                    </ul>

                </li>

                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Setting</span></a>
                    <ul class="pcoded-submenu">

                        <li class="nav-item"><a href="{{route('setting')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-navigation"></i></span><span class="pcoded-mtext">Settings Table</span></a></li>

                        <li class="nav-item"><a href="{{route('setting_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">create Setting Table</span></a></li>


                    </ul>
                </li>

            </ul>
        </div>
    </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->

<!-- [ Header ] start -->
<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
        <a href="index.html" class="b-brand">
            <div class="b-bg">
                <i class="feather icon-trending-up"></i>
            </div>
            <span class="b-title">Datta Able</span>
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

            <li>
                <div class="dropdown drp-user">
                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon feather icon-settings"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head">
                            <img src="{{asset('assets/images/user/avatar-1.jpg')}}" class="img-radius" alt="User-Profile-Image">
                            <span>John Doe</span>

                            <a href="{{ route('logout') }}" class="dud-logout" title="Logout"
                               onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"
                            >
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>

                                <i class="feather icon-log-out"></i>
                            </a>

                        </div>
                        <ul class="pro-body">

                            <li><a href="javascript:" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>

                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<!-- [ Header ] end -->

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->

                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!--[ daily sales section ] start-->
                        @yield('template')
                        <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->

<!-- Warning Section Starts -->
<!-- Older IE warning message -->
<!--[if lt IE 11]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade
        <br/>to any of the following web browsers to access this website.
    </p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/images/browser/ie.png" alt="">
                    <div>IE (11 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
<!-- Warning Section Ends -->

<!-- Required Js -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/pcoded.min.js')}}"></script>
{{--add jquery--}}
{{--<script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>--}}


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jQuery(".approved").click(function(e){
        var element = e.target;
        e.preventDefault();
        var id = jQuery(this).attr('data-id');

        jQuery.ajax({
            type:'POST',
            dataType : 'json',
            url:'/payment/status/'+ id,
            data:{},
            success:function(data){
                if(data.status==200){

                    $(element).closest('tr').find('td.status').find('span').removeClass('label-primary').addClass('label-success');
                    $(element).closest('tr').find('td.status').find('span').html('Approved')
                }


            }
        });
    });





    jQuery(".danger").click(function(a){
        var elements = a.target;
        a.preventDefault();
        var id = jQuery(this).attr('data-id-id');

        jQuery.ajax({
            type:'POST',
            dataType : 'json',
            url:'/payment/status/danger/'+ id,
            data:{},
            success:function(data){
                if(data.status==100){

                    $(elements).closest('tr').find('td.status').find('span').removeClass('label-primary').addClass('label-danger');
                    $(elements).closest('tr').find('td.status').find('span').html('Rejected')
                }
            }
        });
    });






</script>
</body>
</html>