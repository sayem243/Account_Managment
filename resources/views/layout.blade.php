<!DOCTYPE html>
<!--
Template Name: Billing Software
Author: Terminalbd
Website: http://www.terminalbd.com/
Contact: support@terminalbd.com
Follow: www.twitter.com/terminalbd
Dribbble: www.dribbble.com/terminalbd
Like: www.facebook.com/terminalbd

-->
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<!-- start::Head -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - PUL Group</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 4.3 Base Css -->
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet"  type="text/css">
    <link href="{{ asset('assets/plugins/select2/select2-bootstrap4.min.css') }}" rel="stylesheet"  type="text/css">
    <link href="{{ asset('assets/plugins/editor/summernote-bs4.css') }}" rel="stylesheet"  type="text/css">
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"  type="text/css">
    <link href="{{ asset('assets/plugins/DataTables/datatables.css') }}" rel="stylesheet">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/animation/css/animate.min.css') }}">
    <!-- vendor css -->

    @yield('header.styles')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css" >
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css" >
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- Bootstrap & Jquery Base javascript -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js" ></script>
    <script src="{{ asset("assets/jquery/popper.min.js") }}" ></script>
    <script src="{{ asset("assets/bootstrap/js/bootstrap.min.js") }}" ></script>
    <script src="{{ asset("assets/bootstrap/js/bootstrap.bundle.min.js") }}" ></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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

        @media print {
            .hidden-print{
                display: none;
            }
        }

    </style>
</head>
<!-- end::Head -->
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
            <a href="" class="b-brand">
                <div class="b-bg">
                    <i class="feather icon-trending-up"></i>
                </div>
                <span class="b-title">Cash Advance Management</span>
            </a>
            <a class="mobile-menu on" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item">
                    <a href="{{route('admin_index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>

                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{ Request::is('payment')|| Request::is('payment/*') ? 'pcoded-trigger' : ''}}">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="fa fa-credit-card" style="color:green"></i></span><span class="pcoded-mtext">Payements</span></a>
                    <ul class="pcoded-submenu {{ Request::is('payment') || Request::is('payment/*')? 'active' : ''}}">

                        <li class="nav-item {{ Request::is('payment') ? 'active' : ''}}"><a href="{{route('payment')}}" class="nav-link"><span class="pcoded-mtext">Advance Payment</span></a></li>
                        @if(auth()->user()->can('Payment-create'))
                            {{--<li class="nav-item {{ Request::is('payment/create') ? 'active' : ''}}"><a href="{{route('payment_create')}}" class="nav-link"><span class="pcoded-mtext">Add Payment</span></a></li>--}}
                        @endif
                        {{--<li class="nav-item"><a href="{{route('amendment')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-credit-card" aria-hidden="true"></i></span><span class="pcoded-mtext">Amendment</span></a></li>--}}

                    </ul>
                </li>
                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('superadmin') || auth()->user()->can('voucher_create'))

                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{ Request::is('voucher/*') ? 'pcoded-trigger' : ''}}">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-credit-card"></i></span><span class="pcoded-mtext">Voucher</span></a>
                        <ul class="pcoded-submenu {{ Request::is('voucher/*') ? 'active' : ''}}">

                            <li class="nav-item {{ Request::is('voucher/list') ? 'active' : ''}}"><a href="{{route('voucher_index')}}" class="nav-link"><span class="pcoded-mtext">Voucher Item</span></a></li>
                            <li class="nav-item {{ Request::is('voucher/archived/list') ? 'active' : ''}}"><a href="{{route('voucher_archive_index')}}" class="nav-link"><span class="pcoded-mtext">Vouchers</span></a></li>

                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasRole('superadmin')|| auth()->user()->hasRole('CEO') || auth()->user()->can('check-registry-create'))

                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{ Request::is('check/registry/*') ? 'pcoded-trigger' : ''}}">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-credit-card"></i></span><span class="pcoded-mtext">Check Registry</span></a>
                        <ul class="pcoded-submenu {{ Request::is('check/registry/*') ? 'active' : ''}}">
                            <li class="nav-item {{ Request::is('check/registry/index') ? 'active' : ''}}"><a href="{{route('check_registry_index')}}" class="nav-link"><span class="pcoded-mtext">Check Registry</span></a></li>
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->hasRole('superadmin')|| auth()->user()->hasRole('CEO') || auth()->user()->can('loan-income-list'))

                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{ Request::is('loanOrIncome/*') ? 'pcoded-trigger' : ''}} {{ Request::is('loan/*') ? 'pcoded-trigger' : ''}} {{ Request::is('income/*') ? 'pcoded-trigger' : ''}}">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-credit-card"></i></span><span class="pcoded-mtext">Loan & Income</span></a>
                        <ul class="pcoded-submenu {{ Request::is('loanOrIncome/*') ? 'active' : ''}} {{ Request::is('loan/*') ? 'active' : ''}} {{ Request::is('income/*') ? 'active' : ''}}">

                            <li class="nav-item {{ Request::is('loan/index') ? 'active' : ''}}"><a href="{{route('loan_index')}}" class="nav-link"><span class="pcoded-mtext">Loan</span></a></li>
                            <li class="nav-item {{ Request::is('income/index') ? 'active' : ''}}"><a href="{{route('income_index')}}" class="nav-link"><span class="pcoded-mtext">Income</span></a></li>

                        </ul>
                    </li>
                @endif

                @if(auth()->user()->can('daily-cash-balance-session') || auth()->user()->hasRole('Admin') || auth()->user()->hasRole('superadmin')|| auth()->user()->hasRole('CEO'))

                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{ Request::is('daily/cash/*') ? 'pcoded-trigger' : ''}}{{ Request::is('cash/daily/opening/*') ? 'pcoded-trigger' : ''}}">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-credit-card"></i></span><span class="pcoded-mtext">Daily Cash </span></a>
                        <ul class="pcoded-submenu {{ Request::is('daily/cash/*') ? 'active' : ''}}{{ Request::is('cash/daily/opening/*') ? 'active' : ''}}">

                            <li class="nav-item {{ Request::is('daily/cash/balance') ? 'active' : ''}}"><a href="{{route('daily_cash_balance')}}" class="nav-link"><span class="pcoded-mtext">Daily Cash Balance</span></a></li>
                            @if(auth()->user()->can('daily-cash-balance-session')|| auth()->user()->hasRole('superadmin')|| auth()->user()->hasRole('CEO'))
                                <li class="nav-item {{ Request::is('cash/daily/opening/balance/session/list') ? 'active' : ''}}"><a href="{{route('opening_balance_session_list')}}" class="nav-link"><span class="pcoded-mtext">Daily Cash Session</span></a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('superadmin')|| auth()->user()->hasRole('CEO')||auth()->user()->hasRole('Director')|| auth()->user()->hasRole('Manager') || auth()->user()->can('expenditure-sector-list'))
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{ Request::is('account/*') ? 'pcoded-trigger' : ''}}{{ Request::is('bank/*') ? 'pcoded-trigger' : ''}}{{ Request::is('expenditure_sector/*') ? 'pcoded-trigger' : ''}}{{ Request::is('company/*') ? 'pcoded-trigger' : ''}}{{ Request::is('project/*') ? 'pcoded-trigger' : ''}}{{ Request::is('usertype/*') ? 'pcoded-trigger' : ''}}{{ Request::is('client/*') ? 'pcoded-trigger' : ''}}">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Setting</span></a>
                        <ul class="pcoded-submenu {{ Request::is('client/*') ? 'active' : ''}}{{ Request::is('account/*') ? 'active' : ''}}{{ Request::is('bank/*') ? 'active' : ''}}{{ Request::is('expenditure_sector/*') ? 'active' : ''}}{{ Request::is('usertype/*') ? 'active' : ''}}{{ Request::is('company/*') ? 'active' : ''}}{{ Request::is('project/*') ? 'active' : ''}}">
                            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('superadmin')|| auth()->user()->hasRole('CEO')||auth()->user()->hasRole('Director'))
                            <li class="nav-item {{ Request::is('company/index') ? 'active' : ''}}"><a href="{{route('comp_profile')}}" class="nav-link"><span class="pcoded-mtext">Company Profile</span></a></li>
                            @endif
                            @if(auth()->user()->can('projects'))
                            <li class="nav-item {{ Request::is('project/index') ? 'active' : ''}}"><a href="{{route('project')}}" class="nav-link active"><span class="pcoded-mtext">Project</span></a></li>
                            @endif
                            @if(auth()->user()->can('role-list'))
                                <li class="nav-item"><a href="{{route('roles.index')}}" class="nav-link"><span class="pcoded-mtext">Role</span></a></li>
                            @endif
                            {{--<li class="nav-item {{ Request::is('usertype/index') ? 'active' : ''}}"><a href="{{route('usertype')}}" class="nav-link"><span class="pcoded-mtext">User Type</span></a></li>--}}
                            @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('expenditure-sector-list'))
                                <li class="nav-item"><a href="{{route('expenditure_sector_index')}}" class="nav-link"><span class="pcoded-mtext">Expenditure Sector</span></a></li>
                            @endif
                            @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('superadmin'))
                                <li class="nav-item {{ Request::is('bank/index') ? 'active' : ''}}"><a href="{{route('bank_index')}}" class="nav-link"><span class="pcoded-mtext">Bank</span></a></li>
                            @endif
                            @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('superadmin'))
                                <li class="nav-item {{ Request::is('account/index') ? 'active' : ''}}"><a href="{{route('account_index')}}" class="nav-link"><span class="pcoded-mtext">Bank Account</span></a></li>
                            @endif
                            @if(auth()->user()->hasRole('superadmin') || auth()->user()->can('superadmin')|| auth()->user()->hasRole('CEO'))
                                <li class="nav-item {{ Request::is('client/index') ? 'active' : ''}}"><a href="{{route('client_index')}}" class="nav-link"><span class="pcoded-mtext">Client</span></a></li>
                            @endif
                            {{--<li class="nav-item"><a href="{{route('usertype_create')}}" class="nav-link"><span class="pcoded-mtext">Add New</span></a></li>--}}
                        </ul>

                    </li>
                @endif

                @if(auth()->user()->can('users'))
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">User</span></a>
                        <ul class="pcoded-submenu">
                            {{--                        <li class="nav-item"><a href="{{route('userprofile')}}" class="nav-link"><span class="pcoded-mtext">User Profile </span></a></li>--}}
                            <li class="nav-item"><a href="{{route('users.index')}}" class="nav-link"><span class="pcoded-mtext">Users</span></a></li>
                            <li class="nav-item"><a href="{{route('register')}}" class="nav-link"><span class="pcoded-mtext">New User</span></a></li>

                        </ul>
                    </li>
                @endif

{{--                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('CEO')|| auth()->user()->hasRole('Director')|| auth()->user()->hasRole('Manager'))--}}

                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{ Request::is('report/*') ? 'pcoded-trigger' : ''}}{{ Request::is('settlement/*') ? 'active' : ''}}">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-bar-chart" aria-hidden="true"></i></span><span class="pcoded-mtext">Reports</span></a>
                        <ul class="pcoded-submenu {{ Request::is('report/*') ? 'active' : ''}}{{ Request::is('settlement/*') ? 'active' : ''}}">
                            <li class="nav-item {{ Request::is('report/payment') ? 'active' : ''}}"><a href="{{route('payment_report')}}" class="nav-link"><i class="fa fa-bar-chart" aria-hidden="true"></i>Payment Report</a></li>
                            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('CEO')|| auth()->user()->hasRole('Director')|| auth()->user()->hasRole('Manager'))
                            <li class="nav-item {{ Request::is('settlement/list') ? 'active' : ''}}"><a href="{{route('settlement_list')}}" class="nav-link"><span class="pcoded-mtext">Settlement Report</span></a></li>
                            @endif
                        </ul>
                    </li>
                {{--@endif--}}

            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->

<!-- [ Header ] start -->
<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed header-purple">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
        <a href="" class="b-brand">
            <div class="b-bg">
                <i class="feather icon-trending-up"></i>
            </div>
            <span class="b-title"></span>
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
                            @if (Route::has('login'))
                            <img src="{{ asset("assets/images/user/avatar-2.jpg") }}" class="img-radius" alt="User-Profile-Image">
                            <span>{{ Auth::user()->name }}</span>
                                <br>
                                <a style="color: #ffffff;padding-left: 55px" href="{{route('password-change',auth()->user()->id)}}">
                                    Password Change <i class="feather icon-edit"></i>
                                </a>
                                <br>
                                <a style="color: #ffffff;padding-left: 55px; display: block; margin-top: 10px" href="{{ route('logout') }}" class="" title="Logout"
                                   onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"
                                >
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>

                                    Logout <i class="feather icon-log-out"></i>
                                </a>
                            @endif
                        </div>
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
                <div class="col-md-12">
                    @include('flash-message')
                </div>
            @yield('template')
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
</body>

<!-- jQuery 3.2.0 -->

<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset("assets/plugins/cookies/jquery-cookie.js") }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/DataTables/datatables.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
<!-- Common scripts -->


@yield('footer.scripts')
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


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
    });

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

   /* jQuery(".voucher-approve").click(function(a){
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
    });*/

    //amendment approve

    /*jQuery(".amendment_approved").click(function(a){
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
    });*/

    // Report Date Filtering


</script>
<script>
    $('body').on('click', '#mobile-collapse', function(el) {
        var val = $(this).attr('id');
        Cookies.set('productList', "navbar-collapsed");
        $('.pcoded-navbar').addClass(Cookies.set('productList', val));
        setTimeout(location.reload(), 1000);
    });
</script>
</html>
