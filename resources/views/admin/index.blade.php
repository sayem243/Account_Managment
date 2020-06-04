<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') - PUL Group</title>
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

    {{--select2 css--}}


    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome/css/fontawesome-all.min.css')}}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/animation/css/animate.min.css')}}">
    <!-- vendor css -->

    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link href="{{ asset('assets/plugins/DataTables/datatables.css') }}" rel="stylesheet">
    {{--//datepicker--}}


    @yield('header.styles')
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />--}}

    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        .hide{
            display: none!important;
        }
        .btn-group-sm>.btn, .btn-sm {
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.2;
            border-radius: .2rem;
        }
        .pcoded-header{
            z-index: 1028;
            position: relative;
        }

        body {
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
            color: #323437;
            font-weight: 400;
            background: #f4f7fa;
            position: relative;
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
<nav class="pcoded-navbar navbar-collapsed">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="/" class="b-brand">
                <div class="logo">

                    {{--<img src="{{asset('assets/images/ems.png')}}" style="width: 100px" >--}}

                </div>
                <span class="b-title"></span>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>

        <div class="navbar-content scroll-div" >
            <ul class="nav pcoded-inner-navbar">
                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item active">
                    <a href="{{route('admin_index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>

                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{ Request::is('payment')|| Request::is('payment/*') ? 'pcoded-trigger' : ''}}">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="fa fa-credit-card" style="color:green"></i></span><span class="pcoded-mtext">Payements</span></a>
                    <ul class="pcoded-submenu {{ Request::is('payment') || Request::is('payment/*')? 'active' : ''}}">

                        <li class="nav-item {{ Request::is('payment') ? 'active' : ''}}"><a href="{{route('payment')}}" class="nav-link"><span class="pcoded-mtext">Advance Payment</span></a></li>
                        @if(auth()->user()->can('Payment-create'))
                        <li class="nav-item {{ Request::is('payment/create') ? 'active' : ''}}"><a href="{{route('payment_create')}}" class="nav-link"><span class="pcoded-mtext">Add Payment</span></a></li>
                        @endif
                        {{--<li class="nav-item"><a href="{{route('amendment')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-credit-card" aria-hidden="true"></i></span><span class="pcoded-mtext">Amendment</span></a></li>--}}

                    </ul>
                </li>

                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{ Request::is('voucher/*') ? 'pcoded-trigger' : ''}}">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-credit-card"></i></span><span class="pcoded-mtext">Settlement</span></a>
                    <ul class="pcoded-submenu {{ Request::is('voucher/*') ? 'active' : ''}}">

                        <li class="nav-item {{ Request::is('voucher/index') ? 'active' : ''}}"><a href="{{route('voucher_index')}}" class="nav-link"><span class="pcoded-mtext">Settlement</span></a></li>
                        @if(auth()->user()->can('voucher_create'))
                        <li class="nav-item {{ Request::is('voucher/create') ? 'active' : ''}}"><a href="{{route('voucher_create')}}" class="nav-link"><span class="pcoded-mtext">New Settlement</span></a></li>
                        @endif

                    </ul>
                </li>
                @unless(auth()->user()->hasRole('Employee'))
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{ Request::is('company/*') ? 'pcoded-trigger' : ''}}{{ Request::is('project/*') ? 'pcoded-trigger' : ''}}{{ Request::is('usertype/*') ? 'pcoded-trigger' : ''}}">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Setting</span></a>
                        <ul class="pcoded-submenu {{ Request::is('usertype/*') ? 'active' : ''}}{{ Request::is('company/*') ? 'active' : ''}}{{ Request::is('project/*') ? 'active' : ''}}">

                            <li class="nav-item {{ Request::is('company/index') ? 'active' : ''}}"><a href="{{route('comp_profile')}}" class="nav-link"><span class="pcoded-mtext">Company Profile</span></a></li>
                            <li class="nav-item {{ Request::is('project/index') ? 'active' : ''}}"><a href="{{route('project')}}" class="nav-link active"><span class="pcoded-mtext">Project</span></a></li>
                            <li class="nav-item {{ Request::is('usertype/index') ? 'active' : ''}}"><a href="{{route('usertype')}}" class="nav-link"><span class="pcoded-mtext">User Type</span></a></li>
                            {{--<li class="nav-item"><a href="{{route('usertype_create')}}" class="nav-link"><span class="pcoded-mtext">Add New</span></a></li>--}}
                        </ul>

                    </li>
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">User</span></a>
                        <ul class="pcoded-submenu">
                            {{--                        <li class="nav-item"><a href="{{route('userprofile')}}" class="nav-link"><span class="pcoded-mtext">User Profile </span></a></li>--}}
                            <li class="nav-item"><a href="{{route('users.index')}}" class="nav-link"><span class="pcoded-mtext">Users</span></a></li>
                            <li class="nav-item"><a href="{{route('register')}}" class="nav-link"><span class="pcoded-mtext">New User</span></a></li>
                            @if(auth()->user()->can('role-list'))
                                <li class="nav-item"><a href="{{route('roles.index')}}" class="nav-link"><span class="pcoded-mtext">Role</span></a></li>
                            @endif
                        </ul>
                    </li>

                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-user"></i></span><span class="pcoded-mtext">Reports</span></a>
                        <ul class="pcoded-submenu">
                            <li class="nav-item"><a href="{{route('report_index')}}" class="nav-link"><span class="pcoded-mtext">Report </span></a></li>
                            {{--<li class="nav-item"><a href="{{route('report_try')}}" class="nav-link"><span class="pcoded-mtext">Test </span></a></li>--}}

                        </ul>
                    </li>
                @endunless




                {{--<li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">--}}
                    {{--<a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Setting</span></a>--}}
                    {{--<ul class="pcoded-submenu">--}}

                        {{--<li class="nav-item"><a href="{{route('setting')}}" class="nav-link"><span class="pcoded-mtext">Setting</span></a></li>--}}

                        {{--<li class="nav-item"><a href="{{route('setting_create')}}" class="nav-link"><span class="pcoded-mtext">New Setting</span></a></li>--}}


                    {{--</ul>--}}
                {{--</li>--}}



                    {{--roles--}}




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
                            <img src="{{asset('assets/images/user/avatar-1.jpg')}}" class="img-radius" alt="User-Profile-Image">

                            <span>{{ Auth::user()->name }}</span>

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
                        {{--<ul class="pro-body">--}}

                            {{--<li><a href="javascript:" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>--}}

                        {{--</ul>--}}
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

{{--<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
<script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/pcoded.min.js')}}"></script>
{{--add jquery--}}
{{--<script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>--}}
<script src="{{ asset('assets/plugins/DataTables/datatables.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>


@yield('footer.scripts')

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jQuery(".verify").click(function(e){
        var element = e.target;
        e.preventDefault();
        var id = jQuery(this).attr('data-id');
        var payment_status = jQuery(this).attr('data-status');
        if (confirm("Are you sure ?")) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/payment/status/' + id,
                data: {'payment_status':payment_status},
                success: function (data) {
                    if (data.status == 200) {
                        $(element).closest('tr').find('td.status').find('span').removeClass('label-primary').addClass('label-warning');
                        $(element).closest('tr').find('td.status').find('span').html('Verified');

                        location.reload(true);
                    }
                }
            });
        }
    });

    jQuery("#user_id").on('change',function(e){
        var element = e.target;
        e.preventDefault();
        var id = jQuery(this).val();
        if(id<=0){
            return false;
        }
        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/project/user/'+ id,
            data:{},
            success:function(data){
                var dataOption='<option value="0">Select Project</option>';

                for (var i = 0, len = data.length; i < len; i++) {
                    dataOption += '<option value="'+data[i]["id"]+'">'+data[i]["name"]+'</option>';
                }
                jQuery('.user_project_list').html(dataOption);
            }
        });
    }).change();

    //voucher ajax

    jQuery("#voucher_user").on('change',function(e){
        var element = e.target;
        e.preventDefault();
        var id = jQuery(this).val();
        jQuery.ajax({
            type:'GET',
            dataType : 'json',
            url:'/user/payment/'+ id,
            data:{},
            success:function(data){
                console.log(data);
                var dataOption='<option value="0">Select Payment</option>';
                for (var i = 0, len = data.length; i < len; i++) {
                    dataOption += '<option value="'+data[i]["id"]+'">'+data[i]["payment_id"]+'</option>';
                }
                jQuery('.user_payment_list').html(dataOption);
            }
        });
    });


//    payment wise voucher project_list

    jQuery("body").on('change','.user_payment_list',function (e) {

        var element =e.target;
        e.preventDefault();
        var id = jQuery(this).val();
        if(id<=0){
            var dataOption='<option value="0">Select Project</option>';
            jQuery(element).closest('tr').find('.payment_project_list').html(dataOption);
            return false;
        }
        jQuery.ajax({
            type:'GET',
            dataType:'json',
            url:'/user/payment/project/'+id,
            data:{},
            success:function (data) {
                console.log(data);
                var dataOption='<option value="0">Select Project</option>';
                for (var i=0, len=data.length; i<len;i++){
                    dataOption +='<option value="'+data[i]["id"]+'">'+data[i]["project"]+'</option>';
                }
                jQuery(element).closest('tr').find('.payment_project_list').html(dataOption);
            }

        });
    }).change();

    // Paid

    jQuery("body").on('change','.payment_project_list',function (e) {
         var element =e.target;
         e.preventDefault();
         var payment_id =jQuery(this).closest('tr').find('.user_payment_list').val();
         var project_id =jQuery(this).val();
         jQuery.ajax({
            type:'GET',
             dataType:'json',
             url:'/user/payment/paid/'+payment_id+'/'+project_id,
             data:{},
             success:function (data) {

                jQuery(element).closest('tr').find('.paid').html(data.total_amount);
             }
         });

    });

    jQuery(".approved").click(function(a){
        var elements = a.target;
        a.preventDefault();
        var id = jQuery(this).attr('data-id-id');
        if(confirm("Do You want to Approve ?")) {

            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/payment/status/approve/' + id,
                data: {},
                success: function (data) {
                    if (data.status == 100) {
                         {
                            $(elements).closest('tr').find('td.status').find('span').removeClass('label-primary').addClass('label-success');
                            $(elements).closest('tr').find('td.status').find('span').html('Approved')
                             location.reload(true);
                        }
                    }
                }

            });
        }
    });

    jQuery(".payment_paid").click(function(a){
        var elements = a.target;
        a.preventDefault();
        var id = jQuery(this).attr('data-id-id');
        if(confirm("Do You want to Payment Paid ?")) {

            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/payment/status/paid/' + id,
                data: {},
                success: function (data) {
                    if (data.status == 100) {
                         {
                            $(elements).closest('tr').find('td.status').find('span').removeClass('label-primary').addClass('label-success');
                            $(elements).closest('tr').find('td.status').find('span').html('Disbursed');
                             location.reload(true);
                        }
                    }
                }

            });
        }
    });


    jQuery(".voucher-approve").click(function(a){
        var elements = a.target;
        a.preventDefault();
        var id = jQuery(this).attr('data-id-id');
        if(confirm("Do You want to Approve ?")) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/voucher/approved/' + id,
                data: {},
                success: function (data) {
                    if (data.status == 200) {
                        $(elements).closest('tr').find('td.status').find('span').removeClass('label-primary').addClass('label-success');
                        $(elements).closest('tr').find('td.status').find('span').html('Approved')
                        locations.reload(true);
                    }

                }
            });
        }
    });

//amendment approve

    jQuery(".amendment_approved").click(function(a){
        var elements = a.target;
        a.preventDefault();
        var id = jQuery(this).attr('data-id');
        if(confirm("Do You want to Approve ?")) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/amendment/approved/' + id,
                data: {},
                success: function (data) {
                    if (data.status == 200) {
                        $(elements).closest('tr').find('td.status').find('span').removeClass('label-primary').addClass('label-success');
                        $(elements).closest('tr').find('td.status').find('span').html('Approved');
                        location.reload(true);
                    }
                }
            });
        }
    });

    // Report Date Filtering


</script>
</body>
</html>