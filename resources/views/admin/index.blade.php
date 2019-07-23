<!DOCTYPE html>
<html lang="en">

<head>
    <title>Account Managment Project </title>
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
<li class="nav-item">
    <a href="{{route('project')}}" class="nav-link active">
        <span class="pcoded-micon">
            <i class="feather icon-home"></i>
        </span>
        <span class="pcoded-mtext">Project</span>
    </a>
</li>

<li class="nav-item"><a href="{{route('comp_profile')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-navigation"></i></span><span class="pcoded-mtext">company Profile</span></a></li>

 <li class="nav-item"><a href="{{route('payment')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-navigation"></i></span><span class="pcoded-mtext">Payment</span></a></li>

 <li class="nav-item"><a href="{{route('setting')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-navigation"></i></span><span class="pcoded-mtext">Settings Table</span></a></li>
<li class="nav-item"><a href="{{route('comp_create')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-navigation"></i></span><span class="pcoded-mtext">create company profile</span></a></li>




                <li class="nav-item pcoded-menu-caption">
                    <label>Resources & References</label>
                </li>

                <li class="nav-item"><a href="{{route('project_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">create Project Table</span></a></li>

                <li class="nav-item"><a href="{{route('setting_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">create Setting Table</span></a></li>
                <li class="nav-item"><a href="{{route('payment_create')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">create Payment Table</span></a></li>

                <li class="nav-item"><a href="#plugins" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">Plugins</span></a></li>


                <li class="nav-item"><a href="#references" class="nav-link"><span class="pcoded-micon"><i class="fas fa-plug"></i></span><span class="pcoded-mtext">Extra References</span></a></li>
                <li class="nav-item"><a href="#faq" class="nav-link"><span class="pcoded-micon"><i class="feather icon-help-circle"></i></span><span class="pcoded-mtext">FAQ</span></a></li>
                <li class="nav-item"><a href="#cl" class="nav-link"><span class="pcoded-micon"><i class="feather icon-book"></i></span><span class="pcoded-mtext">Change Log</span></a></li>
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
<li>



<form action="https://codedthemes.support-hub.io" target="_blank">

<button type="submit" class="btn btn-secondary"><i class="far fa-life-ring"></i>Support</button>

</form>



</li>

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
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Free Datta Able v2.0 Documentation</h5>
                                        <div class="card-header-right">
                                            <div class="btn-group card-option">
                                                <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-Expand="false">
                                                    <i class="feather icon-more-horizontal"></i>
                                                </button>

                                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                    <li class="dropdown-item minimize-card"><a href="javascript:"><span><i class="feather icon-minus"></i>Collapse</span><span style="display:none"><i class="feather icon-plus"></i> Expand</span></a></li>
                                                    <li class="dropdown-item close-card"><a href="javascript:"><i class="feather icon-trash"></i>Remove</a></li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h6 class="d-inline">Last Update : </h6>
                                        <p class="d-inline"><a href="https://codedthemes.com">14-05-2019</a></p> <br />
                                        <h6 class="d-inline">Author : </h6>
                                        <p class="d-inline"><a href="https://codedthemes.com">Codedthemes</a></p>
                                        <br>
                                        <h6 class="d-inline">Support : </h6>
                                        <p class="d-inline"><a href="https://codedthemes.support-hub.io/" target="_blank">https://codedthemes.support-hub.io/</a></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="card" id="qc">
                                    <div class="card-header">
                                        <h5>Quick Start</h5>
                                        <div class="card-header-right">
                                            <div class="btn-group card-option">
                                                <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-Expand="false">
                                                    <i class="feather icon-more-horizontal"></i>
                                                </button>
                                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                    <li class="dropdown-item minimize-card"><a href="javascript:"><span><i class="feather icon-minus"></i>Collapse</span><span style="display:none"><i class="feather icon-plus"></i>Expand</span></a></li>
                                                    <li class="dropdown-item close-card"><a href="javascript:"><i class="feather icon-trash"></i>Remove</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <p>Copy code directory package in your server. It just the simple way to getting start with Datta Able.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Bootstrap Implementation</h5>
                                        <div class="card-header-right">
                                            <div class="btn-group card-option">
                                                <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-Expand="false">
                                                    <i class="feather icon-more-horizontal"></i>
                                                </button>
                                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                    <li class="dropdown-item minimize-card"><a href="javascript:"><span><i class="feather icon-minus"></i>Collapse</span><span style="display:none"><i class="feather icon-plus"></i> Expand</span></a></li>
                                                    <li class="dropdown-item close-card"><a href="javascript:"><i class="feather icon-trash"></i>Remove</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                            <pre>
                                                <code class="language-markup">
                                                    Datta-able/
                                                    â”œâ”€â”€ assets/
                                                    â”‚   â”œâ”€â”€ css/
                                                    â”‚   â”‚   â”œâ”€â”€ style.css <small class="text-c-red">4) i.e. compiled style.scss</small>
                                                    â”‚   â”œâ”€â”€ plugins/
                                                    â”‚   â”‚   â”œâ”€â”€ bootstrap/
                                                    â”‚   â”‚   â”‚   â”œâ”€â”€ css/
                                                    â”‚   â”‚   â”‚   â”‚   â”œâ”€â”€ bootstrap.min.css <small class="text-c-red">1) bootstrap.min.css v4.1.3</small>
                                                    â”‚   â”‚   â”‚   â”œâ”€â”€ js/
                                                    â”‚   â”‚   â”‚   â”‚   â”œâ”€â”€ .js files
                                                    â”œâ”€â”€ index.html
                                                </code>
                                            </pre>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="card" id="plugins">
                                        <div class="card-header">
                                            <h5>Plugins</h5>
                                            <div class="card-header-right">
                                                <div class="btn-group card-option">
                                                    <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-Expand="false">
                                                        <i class="feather icon-more-horizontal"></i>
                                                    </button>
                                                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                        <li class="dropdown-item minimize-card"><a href="javascript:"><span><i class="feather icon-minus"></i>Collapse</span><span style="display:none"><i class="feather icon-plus"></i> Expand</span></a></li>
                                                        <li class="dropdown-item close-card"><a href="javascript:"><i class="feather icon-trash"></i>Remove</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead class="header-table">
                                                    <tr>
                                                        <th>Plugins Name</th>
                                                        <th>Plugins page use</th>
                                                        <th>Link</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Bootstrap</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default" target="_blank">default.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="https://getbootstrap.com/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Animation</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default/animation.html" target="_blank">animation.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="https://daneden.github.io/animate.css/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Morris chart</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default/chart-morris.html" target="_blank">chart-morris.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="http://morrisjs.github.io/morris.js/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>JQuery</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default" target="_blank">Default.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="https://jquery.com/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>JQuery ui</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default/ac_gridstack.html" target="_blank">ac_gridstack.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="https://jqueryui.com/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Syntax Highlighter</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default/ac_syntax_highlighter.html" target="_blank">ac_syntax_highlighter.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="https://prismjs.com/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Map-Google</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default/map-google.html" target="_blank">map-google.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="http://hpneo.github.io/gmaps/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--
Extra References
-->

                                <div class="col-sm-12">
                                    <div class="card" id="references">
                                        <div class="card-header">
                                            <h5>Extra Assets References</h5>
                                            <div class="card-header-right">
                                                <div class="btn-group card-option">
                                                    <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-Expand="false">
                                                        <i class="feather icon-more-horizontal"></i>
                                                    </button>
                                                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                        <li class="dropdown-item minimize-card"><a href="javascript:"><span><i class="feather icon-minus"></i>Collapse</span><span style="display:none"><i class="feather icon-plus"></i> Expand</span></a></li>
                                                        <li class="dropdown-item close-card"><a href="javascript:"><i class="feather icon-trash"></i>Remove</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <h6>Used Font</h6>
                                                <table class="table table-bordered table-striped">
                                                    <thead class="header-table">
                                                    <tr>
                                                        <th>Font</th>
                                                        <th>Description</th>
                                                        <th>Link</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Google Font</td>
                                                        <td>
                                                            Open-sans
                                                        </td>
                                                        <td>
                                                            <a href="https://getbootstrap.com/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <h6>Font Icons</h6>
                                                <table class="table table-bordered table-striped">
                                                    <thead class="header-table">
                                                    <tr>
                                                        <th>Font Icon</th>
                                                        <th>Description</th>
                                                        <th>Link</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Feather Icon</td>
                                                        <td>
                                                            i.e. default font icon <a href="http://html.codedthemes.com/datta-able/bootstrap/default/icon-feather.html" target="_blank">icon-feather.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="https://feathericons.com/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Font Awesome Icon</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default/icon-fontawsome.html" target="_blank">icon-fontawsome.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="https://fontawesome.com" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Flag Icon</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default/icon-flag.html" target="_blank">icon-flag.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="http://flag-icon-css.lip.is/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Material Icon</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default/icon-material.html" target="_blank">icon-material.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="https://google.github.io/material-design-icons/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Simple Line Icon</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default/icon-simple-line.html" target="_blank">icon-simple-line.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="https://pagellapolitica.it/static/plugins/line-icons/" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Themify Icon</td>
                                                        <td>
                                                            <a href="http://html.codedthemes.com/datta-able/bootstrap/default/icon-themify.html" target="_blank">icon-themify.html</a>
                                                        </td>
                                                        <td>
                                                            <a href="https://themify.me/themify-icons" target="_blank">View Resource</a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <h6>Images reference</h6>
                                                <table class="table table-bordered table-striped">
                                                    <thead class="header-table">
                                                    <tr>
                                                        <th>Link</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="https://iconfinder.com/" target="_blank">Icon Finder</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="https://unsplash.com/" target="_blank">Unsplash Images</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="https://elements.envato.com/" target="_blank">Elements Photos (i.e. not included in package)</a>
                                                        </td>
                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card" id="comp_create">
                                        <div class="card-header">
                                            <h5>FAQ</h5>
                                            <div class="card-header-right">
                                                <div class="btn-group card-option">
                                                    <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-Expand="false">
                                                        <i class="feather icon-more-horizontal"></i>
                                                    </button>
                                                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                        <li class="dropdown-item minimize-card"><a href="javascript:"><span><i class="feather icon-minus"></i>Collapse</span><span style="display:none"><i class="feather icon-plus"></i> Expand</span></a></li>
                                                        <li class="dropdown-item close-card"><a href="javascript:"><i class="feather icon-trash"></i>Remove</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <a href="#!">
                                                <h5 data-toggle="collapse" data-target="#f1" aria-Expand="false" aria-controls="f1">What is <b> Datta Able</b>?</h5>
                                            </a>
                                            <div class="expand" id="f1">
                                                <p class="mb-0">Datta Able is premium dashboard template comes with tons of layout options, widgets, ready to use pages which completely suitable for any complex project.</p>
                                            </div>
                                            <hr>
                                            <a href="#!">
                                                <h5 data-toggle="collapse" data-target="#f2" aria-Expand="false" aria-controls="f2">Why <b>choose</b> Datta Able?</h5>
                                            </a>
                                            <div class="collapse" id="f2">
                                                <p class="mb-0">Datta Able is made by codedthemes's experience coders and designers. Well tested bug free code, easy to use flexible structure makes Datta Able a really differ to other templates. We
                                                    almost cover every possible plugins, components which helps you start immediately on your project.</p>
                                            </div>
                                            <hr>
                                            <a href="#!">
                                                <h5 data-toggle="collapse" data-target="#f4" aria-Expand="false" aria-controls="f4">What about Item <b>Support</b>?</h5>
                                            </a>
                                            <div class="collapse" id="f4">
                                                <p class="mb-0">6 month item support for any bugs, design issue in current version of template. We are not provide support for any custom work implementation.</p>
                                            </div>
                                            <hr>
                                            <a href="#!">
                                                <h5 data-toggle="collapse" data-target="#f5" aria-Expand="false" aria-controls="f5">What is Support <b>Turnaround time?</b></h5>
                                            </a>
                                            <div class="collapse" id="f5">
                                                <p class="mb-0">When you comment or submit the ticket for support. Our team takes it seriously and respond it within a Half or Full day.</p>
                                            </div>
                                            <hr>
                                            <a href="#!">
                                                <h5 data-toggle="collapse" data-target="#f6" aria-Expand="false" aria-controls="f5">Browser <b>Support?</b></h5>
                                            </a>
                                            <div class="collapse" id="f6">
                                                <p class="mb-0">Well tested on IE=>11, Edge, Chrome, Mozilla, Safari, Opera</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card" id="cl">
                                        <div class="card-header">
                                            <h5>Change Log</h5>
                                            <div class="card-header-right">
                                                <div class="btn-group card-option">
                                                    <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-Expand="false">
                                                        <i class="feather icon-more-horizontal"></i>
                                                    </button>
                                                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                        <li class="dropdown-item minimize-card"><a href="javascript:"><span><i class="feather icon-minus"></i>Collapse</span><span style="display:none"><i class="feather icon-plus"></i> Expand</span></a></li>
                                                        <li class="dropdown-item close-card"><a href="javascript:"><i class="feather icon-trash"></i>Remove</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <pre>
                                                <code class="language-markup">


                                                </code>
                                            </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
@yield('template')

</html>
