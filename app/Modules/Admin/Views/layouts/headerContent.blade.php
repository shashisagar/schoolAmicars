<div class="navbar">
    <div class="navbar-inner">
        <div class="sidebar-pusher">
            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="logo-box">
            <a href="/dashboard" class="logo-text"><span>{{trans('message.MySchoolApp')}}</span></a>
        </div>
        <div class="topmenu-outer">
            <div class="top-menu">

                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="javascript:void(0);"
                           class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                           data-toggle="dropdown">
                                        <span class="user-name">{{ trans('message.changelanguage') }}<i
                                                    class="fa fa-angle-down"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/lang/en">{{trans('message.english')}}</a></li>
                            <li><a href="/lang/hr">{{trans('message.hebrew')}}</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                           data-toggle="dropdown">
                            @if(Auth::user()->role == 1)
                                <span class="user-name">{{trans('message.SuperAdmin')}}<i class="fa fa-angle-down"></i></span>
                            @else
                                @if(Auth::user()->role == 2)
                                    <span class="user-name">{{trans('message.MainTeacher')}}<i class="fa fa-angle-down"></i></span>
                                @else
                                    @if(Auth::user()->role == 3)
                                        <span class="user-name">{{trans('message.MainStudent')}}<i class="fa fa-angle-down"></i></span>
                                    @endif
                                @endif
                            @endif
                            <img class="img-circle avatar" src="
                                 @if(Auth::user()->profilepic == '' || Auth::user()->profilepic == NULL)
                                    /image/uploads_userAvatar_avatar.png
                                 @else
                            {{Auth::user()->profilepic}}
                            @endif
                                    " width="40" height="40" title="{{Auth::user()->name}}">
                        </a>
                        <ul class="dropdown-menu dropdown-list" role="menu">
                            <li role="presentation">
                                <a href="/profile"><i class="fa fa-user"></i>{{trans('message.Profile')}}</a>
                            </li>
                            <li role="presentation">
                                <a href="/update-password"><i class="fa fa-wrench"></i>{{trans('message.UpdatePassword')}}</a>
                            </li>
                            <li role="presentation">
                                <a href="/logout">
                                    <i class="fa fa-sign-out m-r-xs"></i>{{trans('message.Logout')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Nav -->
            </div>
            <!-- Top Menu -->
        </div>
    </div>
</div>


    {{--<script type="text/javascript">--}}
        {{--function googleTranslateElementInit() {--}}
            {{--new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,iw', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');--}}
        {{--}--}}
{{--</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>--}}


{{--<style>--}}
    {{--.goog-te-gadget-icon {--}}
        {{--display: none;--}}
    {{--}--}}
    {{--.goog-te-gadget-simple {--}}
        {{--margin-top: 17px;--}}
    {{--}--}}
{{--</style>--}}

