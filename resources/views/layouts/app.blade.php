<!-- - var menuBorder = true-->
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="Arif Ahmmad Dip">

    <title>{{ config('app.name') }}</title>

    <!-- Logo favicon -->
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/logo-black-01.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/logo-black-01.png') }}">
    <!-- Logo favicon -->

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/sweetalert/sweetalert.css') }}">

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css') }}">
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/bootstrap_date_picker/css/bootstrap-datepicker.css') }}">--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/fontawesome-free-6.2.0-web/css/all.min.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-climacon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->

    <style>
        .brand-logo{
            height: 25px;
            width: auto;
        }

        .form-group .required:after {
            content:"*";
            color:red;
        }

        .dash-brand-logo{
            height: 100px;
            width: auto;
        }

        .loader {
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    @yield('css')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-light navbar-border">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu font-large-1"></i></a></li>
                <li class="nav-item"><a class="navbar-brand" href="{{ url('/') }}"><h2 class="brand-text">{{ config('app.name') }}</h2></a></li>
                <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu"></i></a></li>
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon feather icon-maximize"></i></a></li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="avatar avatar-online">
                                <img src="{{ asset('img/No_profile-image.png') }}" alt="avatar">
                                <i></i>
                            </div><span class="user-name">{{ auth()->user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('/user-account-setting/') }}"><i class="feather icon-user"></i> Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:logout();"><i class="feather icon-power"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->

<!-- BEGIN: Main Menu-->


<div class="main-menu menu-fixed menu-light menu-accordion" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header">
                <span>Menu</span>
                <i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="General"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-layers"></i><span class="menu-title" data-i18n="Account">Event</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('event.add') }}" data-i18n="EventAdd">New Event</a></li>
                    <li><a class="menu-item" href="{{ route('event.record') }}" data-i18n="EventList">Event List</a></li>
                    <li><a class="menu-item" href="{{ route('event.guest.record') }}" data-i18n="EventGuestList">Event Guest List</a></li>
                </ul>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('user.record') }}"><i class="feather icon-users"></i><span class="menu-title" data-i18n="User List">User List</span></a>--}}
{{--            </li>--}}
        </ul>
    </div>
</div>
<!-- END: Main Menu-->

@yield('content')

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light navbar-border">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
        <span class="float-md-left d-block d-md-inline-block">Develop & Maintained by <a class="text-bold-800 grey darken-2" href="#" target="_blank">Arif Ahmmad</a></span>
    </p>
</footer>
<!-- END: Footer-->

<!-- BEGIN: Vendor JS-->
<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/sweetalert/sweetalert.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
{{--<script src="{{ asset('app-assets/vendors/bootstrap_date_picker/js/bootstrap-datepicker.js') }}"></script>--}}
<script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('app-assets/js/core/app.js') }}"></script>
<script src="{{ asset('app-assets/vendors/fontawesome-free-6.2.0-web/js/all.min.js') }}"></script>
<!-- END: Theme JS-->



<script>
    $(function(){
        $.each($('#main-menu-navigation .nav-item').find('a'), function (index, value) {
            var currentUrl = window.location.href.split('?')[0];

            if (value.href.split('?')[0] == currentUrl){
                $(value).parent().addClass('active');
                $(value).parent().parent().addClass('open');
                $(value).parent().parent().parent().addClass('open');
                count = 1;
            }
        });

        // $('.input-group.date').datepicker({
        //     format: "yyyy-mm-dd",
        //     weekStart: 6,
        //     todayBtn: true,
        //     keyboardNavigation: false,
        //     daysOfWeekHighlighted: "5",
        //     autoclose: true,
        //     todayHighlight: true
        // });

        @if (Session::has('message'))
            swal({
                title            : "Success !",
                text             : "{{ session('message') }}",
                type             : "success",
                showCancelButton : false,
                showConfirmButton: false,
                timer            : 3000,
            });
        @endif
        @if (Session::has('error'))
            swal({
                title            : "Sorry !",
                text             : "{{ session('error') }}",
                type             : "error",
                showCancelButton : false,
                showConfirmButton: false,
                timer            : 3000,
            });
        @endif
        @if (Session::has('info'))
            swal({
                title            : "Sorry !",
                text             : "{{ session('info') }}",
                type             : "warning",
                showCancelButton : false,
                showConfirmButton: false,
                timer            : 3000,
            });
        @endif
        @if (Session::has('warning'))
            swal({
                title            : "Sorry !",
                text             : "{{ session('warning') }}",
                type             : "warning",
                showCancelButton : false,
                showConfirmButton: false,
                timer            : 3000,
            });
        @endif
    });

    function logout(){
        $('#logout-form').submit();
    }
</script>

@stack('js')

</body>
<!-- END: Body-->

</html>
