<div class="page-sidebar sidebar">
    <div class="page-sidebar-inner slimscroll">
        <div class="sidebar-header">
            <div class="sidebar-profile">
                <a href="javascript:void(0);" id="profile-menu-link">
                    <div class="sidebar-profile-image">
                        <img src="
                         @if(Auth::user()->profilepic == '' || Auth::user()->profilepic == NULL)
                                /image/uploads_userAvatar_avatar.png
                         @else
                        {{Auth::user()->profilepic}}
                        @endif
                                " class="img-circle img-responsive">
                    </div>
                    <div class="sidebar-profile-details">
                        <span>{{  Auth::user()->name}}<br>
                            @if(Auth::user()->role==1)
                                <small>{{trans('message.SuperAdmin')}}</small>
                            @else
                                @if(Auth::user()->role==2)
                                    <small>{{trans('message.MainTeacher')}}</small>
                                @else
                                    @if(Auth::user()->role==3)
                                        <small>{{trans('message.MainStudent')}}</small>
                                    @endif
                                @endif
                            @endif
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <ul class="menu accordion-menu">
            <li id="dashboard">
                <a href="/dashboard" class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-home"></span>

                    <p>{{trans('message.Dashboard')}}</p>
                </a>
            </li>

            <li id="assigncourse" class="droplink">
                <a class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-film"></span>
                    <p>{{trans('message.AssignCourses')}}</p> <span class="arrow"></span>

                </a>
                <ul class="sub-menu">
                    <li id="addSchoolCourse"><a href="/add-school-course">{{trans('message.AssignCourses&Teacher')}}</a></li>
                </ul>
            </li>

            @if(Auth::user()->role == 1)

                <li id="school" class="droplink">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon glyphicon glyphicon-film"></span>
                        <p>{{trans('message.School')}}</p> <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li id="viewSchool"><a href="/manage-school">{{trans('message.ViewSchool')}}</a></li>
                        <li id="addSchool"><a href="/add-school">{{trans('message.AddSchool')}}</a></li>
                    </ul>
                </li>

                <li id="teacher" class="droplink">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon glyphicon glyphicon-film"></span>
                        <p> {{trans('message.MainTeacher')}}</p> <span class="arrow"></span>


                    </a>
                    <ul class="sub-menu">
                        <li id="viewTeacher"><a href="/manage-teacher"> {{trans('message.ViewMainTeacher')}}</a></li>
                        <li id="addTeacher"><a href="/add-teacher"> {{trans('message.AddMainTeacher')}}</a></li>
                    </ul>
                </li>

                <li id="student" class="droplink">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon glyphicon glyphicon-film"></span>
                        <p> {{trans('message.MainStudent')}}</p> <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li id="viewStudent"><a href="/manage-student">{{trans('message.ViewMainStudent')}}</a></li>
                        <li id="addStudent"><a href="/add-student">{{trans('message.AddMainStudent')}}</a></li>
                    </ul>
                </li>

            @endif

            <li id="courses" class="droplink">
                <a class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-film"></span>
                    <p>{{trans('message.MainCourses')}}</p> <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li id="viewCourses"><a href="/manage-courses">{{trans('message.ViewCourses')}}</a></li>
                    <li id="addCourses"><a href="/add-courses">{{trans('message.AddCourses')}}</a></li>
                </ul>
            </li>

            <li id="normalteacher" class="droplink">
                <a class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-film"></span>
                    <p>{{trans('message.NormalTeacher')}}</p> <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li id="viewNormalTeacher"><a href="/manage-normalTeacher">{{trans('message.ViewNormalTeacher')}}</a></li>
                    <li id="addNormalTeacher"><a href="/add-normal-teacher">{{trans('message.AddNormalTeacher')}}</a></li>
                </ul>
            </li>


            <li id="courseTopic" class="droplink">
                <a class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-film"></span>
                    <p>{{trans('message.MainTopic')}}</p> <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li id="viewcourseTopic"><a href="/manage-course-topics">{{trans('message.ViewTopics')}}</a></li>
                    <li id="addcourseTopic"><a href="/add-course-topic">{{trans('message.AddCourseTopic')}}</a></li>
                </ul>
            </li>


            <li id="courseScientificTerm" class="droplink">
                <a class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-film"></span>
                    <p>{{trans('message.ScientificTerm')}}</p> <span class="arrow"></span>


                </a>
                <ul class="sub-menu">
                    <li id="viewcourseScientificTerm"><a href="/manage-scientific-term">{{trans('message.ViewScientificTerm')}}</a></li>
                    <li id="addcourseScientificTerm"><a href="/add-scientific-term">{{trans('message.AddScientificTerm')}}</a></li>
                </ul>
            </li>

            <li id="courseScientificRule" class="droplink">
                <a class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-film"></span>
                    <p>{{trans('message.ScientificRule')}}</p> <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li id="viewcourseScientificRule"><a href="/manage-scientific-rule">{{trans('message.ViewScientificRule')}}</a></li>
                    <li id="addcourseScientificRule"><a href="/add-scientific-rule">{{trans('message.AddScientificRule')}}</a></li>
                </ul>
            </li>








            <li id="allReport" class="droplink">
                <a class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-film"></span>
                    <p>{{trans('message.Report')}}</p> <span class="arrow"></span>

                </a>
                <ul class="sub-menu">
                    <li id="reportOnedetails"><a href="/reportOne-details">{{trans('message.ReportOne')}}</a></li>
                    <li id="reportTwodetails"><a href="/reportTwo-details">{{trans('message.ReportTwo')}}</a></li>
                    <li id="reportThreedetails"><a href="/reportThree-details">{{trans('message.ReportThree')}}</a></li>

                </ul>
            </li>


        </ul>
    </div>
</div>

<style>
    .goog-te-banner-frame.skiptranslate {display: none !important;} body { top: 0px !important; }
    #goog-gt-tt{
        display: none !important;
    }
    .goog-tooltip:hover {
        display: none !important;
    }
    .goog-text-highlight {
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
</style>