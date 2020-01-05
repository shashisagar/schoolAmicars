<!DOCTYPE html>
<html>
    <head>
        @include('Admin::layouts.headContent')
    </head>
    <body class="page-header-fixed compact-menu page-sidebar-fixed">

    <main class="page-content content-wrap">

            @include('Admin::layouts.headerContent')
            @include('Admin::layouts.sideMenuContent')

            <div class="page-inner">
                <div class="page-title">
                    <h3><b>@yield('pageTitle')</b></h3>
                    <div class="page-breadcrumb">
                        {{--<ol class="breadcrumb">--}}
                            {{--<li>--}}
                                {{--<a href="/dashboard" style="color:#4e5e6a; text-decoration: none;">--}}
                                    {{--{{trans('message.Admin')}}--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="active"></li>--}}
                        {{--</ol>--}}
                        <!-- Active menu link will be append here -->
                        @yield('menuLink')
                    </div>
                </div>
                <div id="main-wrapper">
                    <!-- Extra body content will be append here -->
                    @yield('content')
                </div>
                <!-- body footer -->
                <div class="page-footer">
                    <p class="no-s">{{date('Y')}} &copy; {{trans('message.MySchool')}}</p>
                </div>
            </div>

        </main>

        <!--body model will be append here -->
        @yield('modal')

        @include('Admin::layouts.bodyCommonScripts')

        <!-- Extra body script will be append here -->
        @yield('bodyScript')

        <script src="/assets/js/modern.js"></script>

        </body>
</html>