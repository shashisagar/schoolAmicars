@extends('Admin::layouts.master')

@section('title')
    {{trans('message.EditMainCourses')}}
@endsection

@section('pageTitle')
    {{trans('message.EditMainCourses')}}
@endsection



@section('menuLink')
    <ol class="breadcrumb">
        <li>
            <a href="/manage-courses" style="color:#4e5e6a; text-decoration: none;">
                {{trans('message.MainCourses')}}
            </a>
        </li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>
            <a href="/manage-courses" style="color:#4e5e6a; text-decoration: none;">
                {{trans('message.ViewMainCourse')}}
            </a>
        </li>
        <li class="active"></li>
    </ol>
    <ol class="breadcrumb">
        <li>{{trans('message.EditMainCourses')}}</li>
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
                    <h4 class="panel-title">{{trans('message.Edit/UpdateMainCourses')}}</h4>
                </div>
                <div class="panel-body">
                    @if(empty($courseDetails))
                        <div style="text-align: center">
                            <h2>This teacher does not exist.</h2><br>
                            <a href="/manage-teacher">
                                <button class="btn btn-xs btn-success">Go back</button>
                            </a>
                        </div>
                    @else
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
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{trans('message.Name')}}</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="name"
                                               value="{{null != old('name')  ? old('name') : $courseDetails['course_name']}}">
                                        <span class="error">{!! $errors->first('name') !!}</span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                    {{--@if (Auth::user()->role == 1)--}}
                                    {{----}}
                                    {{--@endif--}}


                            </div>
                            <div class="form-actions">
                                <div class="col-md-offset-6 col-md-9">
                                    <button class="btn blue btn-info" type="submit">{{trans('message.Update')}}</button>
                                </div>
                            </div>
                        </form>
                    @endif
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
            $('#teacher, #viewTeacher').addClass('active');
            $('#teacher').addClass('open');

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
@endsection


