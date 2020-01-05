@extends('Admin::layouts.master')

@section('title')
    {{trans('message.EditTerm')}}
@endsection

@section('pageTitle')
    {{trans('message.EditTerm')}}
@endsection

@section('menuLink')
    <ol class="breadcrumb">
        <li>{{trans('message.EditTerm')}}</li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>{{trans('message.EditTerm')}}</li>
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
                    <h4 class="panel-title">{{trans('message.EditTerm')}}</h4>
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

                            @foreach($scientificTerm as $key => $value)
                                <input type="hidden" class="form-control" name="scientific_term_id" value="{{$value->scientific_terms_id}}">

                            @endforeach

                            {{--@if(Auth::user()->role == 1)--}}
                                {{--<div class="form-group">--}}
                                    {{--<label class="col-sm-2 control-label">{{trans('message.SelectSchool')}}</label>--}}
                                    {{--<div class="col-sm-4">--}}
                                        {{--<select class="js-example-responsive form-control" name="school" id="myschool">--}}
                                            {{--<option value="">--{{trans('message.Select')}}--</option>--}}
                                            {{--@if(!empty($schoolList))--}}
                                                {{--@foreach($schoolList as $key => $value)--}}
                                                    {{--<option @if($schoolName['schools_id']== $value->schools_id) selected--}}
                                                            {{--@endif value="{{$value->schools_id}}">{{$value->name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--@endif--}}
                                        {{--</select>--}}
                                        {{--<span class="error">{!! $errors->first('school') !!}</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}


                                {{--<div class="form-group">--}}
                                    {{--<label class="col-sm-2 control-label">{{trans('message.CourseName')}}</label>--}}
                                    {{--<div class="col-sm-4">--}}
                                        {{--<select class="js-example-responsive form-control" name="course_name" id="courseList1">--}}
                                            {{--<option value="">--{{trans('message.Select')}}--</option>--}}
                                            {{--@if(!empty($courseList))--}}
                                                {{--@foreach($courseList as $key => $value)--}}
                                                    {{--<option @if($courseName['courses_id']== $value->courses_id) selected--}}
                                                            {{--@endif value="{{$value->courses_id}}">{{$value->course_name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--@endif--}}
                                        {{--</select>--}}
                                        {{--<span class="error">{!! $errors->first('course_name') !!}</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}


                            {{--@else--}}
                                {{--<div class="form-group">--}}
                                    {{--<label class="col-sm-2 control-label">Course Name</label>--}}
                                    {{--<div class="col-sm-4">--}}
                                        {{--<select class="js-example-responsive form-control" name="course_name" id="courseList">--}}
                                            {{--<option value="">--{{trans('message.Select')}}--</option>--}}
                                            {{--@if(!empty($allCourses))--}}
                                                {{--@foreach($allCourses as $key => $value)--}}
                                                    {{--<option @if(old('school')== $value->courses_id) selected--}}
                                                            {{--@endif value="{{$value->courses_id}}">{{$value->course_name}}--}}
                                                    {{--</option>--}}
                                                {{--@endforeach--}}
                                            {{--@endif--}}
                                        {{--</select>--}}
                                        {{--<span class="error">{!! $errors->first('course_name') !!}</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}

                            {{--@endif--}}

                            {{--<div class="form-group">--}}
                                {{--<label class="col-sm-2 control-label">{{trans('message.TeachingStage')}}</label>--}}
                                {{--<div class="col-sm-4">--}}
                                    {{--<select class="js-example-responsive form-control" name="teaching_stage">--}}
                                        {{--<option value="">--{{trans('message.Select')}}--</option>--}}
                                        {{--@if(!empty($teaching_stage))--}}
                                            {{--@foreach($teaching_stage as $key => $value)--}}
                                                {{--<option @if($teachingName['teaching_stage_id']== $value->teaching_stage_id) selected--}}
                                                        {{--@endif value="{{$value->teaching_stage_id}}">{{$value->name}}</option>--}}
                                            {{--@endforeach--}}
                                        {{--@endif--}}
                                    {{--</select>--}}
                                    {{--<span class="error">{!! $errors->first('teaching_stage') !!}</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="clearfix"></div>--}}



                                {{--<div class="form-group">--}}
                                    {{--<label class="col-sm-2 control-label">{{trans('message.TopicName')}}</label>--}}
                                    {{--<div class="col-sm-4">--}}

                                            {{--<input type="text" class="form-control" name="course_topic_name" value="{{$topicName}}">--}}

                                        {{--<span class="error">{!! $errors->first('course_topic_name') !!}</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}
                        {{--</div>--}}




                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('message.ScientificTerm')}}</label>
                                <div class="col-sm-4">
                                    @foreach($scientificTerm as $key => $value)
                                        <input type="text" class="form-control" name="scientific_term" value="{{$value->scientific_term}}">
                                    @endforeach
                                    <span class="error">{!! $errors->first('scientific_term') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn blue btn-info" type="submit">{{trans('message.Update')}}</button>
                            </div>
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

    <script>
        $("#myschool").on('change', function(event){
            event.preventDefault();
            var school_id = $(this).val();

            makeAjaxRequest(school_id);
        });
        function makeAjaxRequest(school_id){
            $.ajax({
                type: "GET",
                data: { school_id: school_id },
                url: "/courses-per-school",
                success: function(res) {
                    $("#courseList1").html(res);
                    $("#courseList2").html(res);

                }
            });
        }
    </script>

@endsection
