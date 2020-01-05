@extends('Admin::layouts.master')
@section('title', 'Add Scientific term/rule')
@section('pageTitle', 'Add Scientific term/rule')

@section('menuLink')
    <ol class="breadcrumb">
        <li>Add Scientific term/rule</li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>Add Scientific term/rule</li>
    </ol>
@endsection


@section('head')
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="panel info-box panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">Add Topics Scientific term/rule</h4>
                </div>
                <div class="panel-body">
                    <div class="alert
                    @if(session('code')) @if(session('code') == 400) alert-danger @elseif(session('code') == 200) alert-success @else display-hide @endif
                    @else display-hide @endif">
                        <button class="close" data-close="alert"></button>
                        <span>
                            @if(session('code') == 400 || session('code') == 200)
                                <?php echo session('message'); ?>
                            @endif
                        </span>
                    </div>

                    <form class="form-horizontal" method="post">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="form-body">

                            @if(Auth::user()->role == 1)

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Select School</label>
                                <div class="col-sm-4">
                                    <select class="js-example-responsive form-control" name="school" id="term_school">
                                        <option value="">--Select--</option>
                                        @if(!empty($schoolList))
                                            @foreach($schoolList as $key => $value)
                                                <option @if(old('school')== $value->schools_id) selected
                                                        @endif value="{{$value->schools_id}}">{{$value->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="error">{!! $errors->first('school') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Course Name</label>
                                    <div class="col-sm-4">
                                        <select class="js-example-responsive form-control" name="course_name" id="mycoursesList">
                                            <option value="">--Select--</option>
                                            {{--@if(!empty($allCourses))--}}
                                            {{--@foreach($allCourses as $key => $value)--}}
                                            {{--<option @if(old('school')== $value->courses_id) selected--}}
                                            {{--@endif value="{{$value->courses_id}}">{{$value->course_name}}--}}
                                            {{--</option>--}}
                                            {{--@endforeach--}}
                                            {{--@endif--}}
                                        </select>
                                        <span class="error">{!! $errors->first('course_name') !!}</span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>


                            @else
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Course Name</label>
                                    <div class="col-sm-4">
                                        <select class="js-example-responsive form-control" name="course_name" id="mycoursesList">
                                            <option value="">--Select--</option>
                                            @if(!empty($allCourses))
                                            @foreach($allCourses as $key => $value)
                                            <option @if(old('school')== $value->courses_id) selected
                                            @endif value="{{$value->courses_id}}">{{$value->course_name}}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <span class="error">{!! $errors->first('course_name') !!}</span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            @endif



                            <div class="form-group">
                                <label class="col-sm-2 control-label">Teaching stage</label>
                                <div class="col-sm-4">
                                    <select class="js-example-responsive form-control" name="teaching_stage">
                                        <option value="">--Select--</option>
                                        @if(!empty($teaching_stage))
                                            @foreach($teaching_stage as $key => $value)
                                                <option @if(old('school')== $value->teaching_stage_id) selected
                                                        @endif value="{{$value->teaching_stage_id}}">{{$value->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="error">{!! $errors->first('teaching_stage') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">Topic Name</label>
                                <div class="col-sm-4">
                                    <select class="js-example-responsive form-control" name="topic_name" id="allTopicList">
                                        <option value="">--Select--</option>
                                        {{--@if(!empty($topicList))--}}

                                            {{--@foreach($topicList as $key => $value)--}}
                                                {{--<option @if(old('school')== $value->topic_id) selected--}}
                                                        {{--@endif value="{{$value->topic_id}}">{{$value->topic_name}}--}}
                                                {{--</option>--}}
                                            {{--@endforeach--}}
                                        {{--@endif--}}
                                    </select>
                                    <span class="error">{!! $errors->first('topic_name') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">Scientific Term</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="scientific_term" value="{{old('scientific_term')}}">
                                    <span class="error">{!! $errors->first('scientific_term') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">Scientific Rule</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="scientific_rule" value="{{old('scientific_rule')}}">
                                    <span class="error">{!! $errors->first('scientific_rule') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>


                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn blue btn-info" type="submit">Add Scientific term/rule</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('bodyScript')
    <script src="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>

    <script>
        $(document).ready(function () {
            //for activate the side menu
            $('#student, #addStudent').addClass('active');
            $('#student').addClass('open');

//      =========================================================================

            var status = "info";
            @if(session('message')!='')
                    @if(session('code') == '200')
                    status = "success";
            @elseif(session('code') == '400')
                    status = "error";
            @endif
                    toastr[status]("{{session('message')}}");
            @endif

        });

    </script>

    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}

    <script>
        $("#term_school").on('change', function(event){
            event.preventDefault();
            var term_school_id = $(this).val();

            findSchoolCourses(term_school_id);
        });
        function findSchoolCourses(term_school_id){
            $.ajax({
                type: "GET",
                data: { term_school_id: term_school_id },
                url: "/term-courses-per-school",
                success: function(res) {

                    $("#mycoursesList").html(res);

                }
            });
        }

        $("#mycoursesList").on('change', function(event){
            event.preventDefault();
            var term_courses_id = $(this).val();

            findCoursesTopic(term_courses_id);
        });
        function findCoursesTopic(term_courses_id){
            $.ajax({
                type: "GET",
                data: { term_courses_id: term_courses_id },
                url: "/topic-per-courses",
                success: function(res) {

                    $("#allTopicList").html(res);

                }
            });
        }
    </script>

@endsection
