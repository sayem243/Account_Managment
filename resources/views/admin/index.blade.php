<!DOCTYPE html>
<html lang="en">

<head>

    @include('admin.partials.csslink')

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



                    <img src="{{asset('assets/images/ems.png')}}" style="width: 100px" >

                </div>
                <span class="b-title"></span>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">



                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item active">
                    <a href="{{route('admin_index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>


                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="fa fa-credit-card" style="color:green"></i></span><span class="pcoded-mtext">Payements</span></a>
                    <ul class="pcoded-submenu">

                        <li class="nav-item"><a href="{{route('payment')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-credit-card" aria-hidden="true"></i></span><span class="pcoded-mtext">Payment</span></a></li>
                        <li class="nav-item"><a href="{{route('payment_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-credit-card" aria-hidden="true"></i></span><span class="pcoded-mtext">Add Payment</span></a></li>

                        {{--<li class="nav-item"><a href="{{route('amendment_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-credit-card" aria-hidden="true"></i></span><span class="pcoded-mtext">Amendment</span></a></li>--}}

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
                            <img src="assets/images/user/avatar-1.jpg" class="img-radius" alt="User-Profile-Image">
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

                {{--<div class="main-body">--}}
                    {{--<div class="page-wrapper">--}}

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

    @include('admin.partials.script')
</div>

</body>

</html>
