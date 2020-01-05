<!-- Title -->
<title> {{trans('message.MySchool')}} || @yield('title')</title>

<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta charset="UTF-8">
<meta name="description" content="school"/>
<meta name="keywords" content="school,class,college,study,admission,fees"/>
<meta name="author" content="School Admin | Shashi Sagar"/>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Styles -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
<link href="/assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
<link href="/assets/plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
<link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/slidepushmenus/css/component.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/weather-icons-master/css/weather-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/metrojs/MetroJs.min.css" rel="stylesheet" type="text/css"/>


{{--FOR UI-NOTIFICATIONS--}}
<link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet"/>

<!-- Theme Styles -->
<link href="/assets/css/modern.css" rel="stylesheet" type="text/css"/>
<link href="/assets/css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>
<!--white.css-->
<link href="/assets/css/custom.css" rel="stylesheet" type="text/css"/>

<!--This is a theme style for select type field-->
<link href="/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css"/>

<!-- Extra head will be append here -->
@yield('head')

<style>
    label.error {
        font-weight: normal;
        color: #FF0000 !important;
    }

    span.error {
        font-weight: normal;
        color: #FF0000 !important;
    }

    .bg-white {
        background: #fff !important;
        text-align: left !important;
        border-bottom: 1px solid #e3e3e3 !important;
        color: #5f5f5f !important;
    }

    .bg-white:hover {
        background: #f7f7f7 !important;
    }

    .bg-white:hover {
        background: #f7f7f7 !important;
    }

    .text-left {
        text-align: left !important;
    }

    .arrows::before {
        margin-top: 0px !important;
    }

    .bg_grey {
        background: #f9f9f9 !important;
        padding: 0 !important;
    }

    ul.bg_grey li a {
        padding: 7px 10px !important;
        border-bottom: 1px solid #e3e3e3;
    }

    ul.bg_grey li a:hover {
        background: #fff !important;
    }

    .top-menu .accordion-menu a {
        padding: 9px 19px !important;

    }

    .userDefineArrow::before {
        color: #4e5e6a;
        content: "-->";
        padding: 0 5px;
        font-size: 12px;
    }

    #subMenuColor {
        background: #F7F7F7;
        color:#899dc1;
    }
    #subMenuColor:hover {
        background: #fff;
        color:#5F5F5F;
    }


</style>


<!-- Head javascript -->
<script src="/assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
<script src="/assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->


