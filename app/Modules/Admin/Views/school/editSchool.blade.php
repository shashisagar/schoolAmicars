@extends('Admin::layouts.master')


@section('title')
    {{trans('message.EditSchool')}}
@endsection

@section('pageTitle')
    {{trans('message.EditSchoolDetail')}}
@endsection

@section('menuLink')
    <ol class="breadcrumb">
        <li>
            <a href="/manage-school" style="color:#4e5e6a; text-decoration: none;">
                {{trans('message.School')}}
            </a>
        </li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>
            <a href="/manage-school" style="color:#4e5e6a; text-decoration: none;">
                {{trans('message.ViewSchool')}}
            </a>
        </li>
        <li class="active"></li>
    </ol>
    <ol class="breadcrumb">
        <li>{{trans('message.EditSchool')}}</li>
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
                    <h4 class="panel-title">{{trans('message.Edit/UpdateSchool')}}</h4>
                </div>
                <div class="panel-body">
                    @if(empty($schoolDetails))
                        <div style="text-align: center">
                            <h2>This school does not exist.</h2><br>
                            <a href="/manage-school">
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

                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{trans('message.SchoolName')}}</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="school_name"
                                               value="{{null != old('school_name')  ? old('school_name') : $schoolDetails['name']}}">
                                        <span class="error">{!! $errors->first('school_name') !!}</span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{trans('message.MainImage')}}</label>
                                    <div class="text-center col-md-4">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php $schoolDetails['image_1'] == NULL  ? $url = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' : $url = $schoolDetails['image_1'] ?>
                                                <img src={{$url}} alt=""/>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                            </div>
                                            <div>
                                            <span class="btn default btn-primary btn-file">
                                            <span class="fileinput-new"> {{trans('message.SelectImage')}} </span>
                                            <span class="fileinput-exists"> {{trans('message.Change')}} </span>
                                            <input type="file" name="main_image">
                                        </span>
                                                <a href="#" class="btn default btn-danger fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                            <span class="error">{!! $errors->first('main_image') !!}</span>
                                        </div>
                                    </div>
                                    <label class="col-sm-2 control-label">{{trans('message.OtherImage')}}</label>
                                    <div class="text-center col-md-2">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php $schoolDetails['image_2'] == NULL  ? $url = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' : $url = $schoolDetails['image_2'] ?>
                                                <img src={{$url}} alt=""/>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                            </div>
                                            <div>
                                            <span class="btn default btn-primary btn-file">
                                            <span class="fileinput-new"> {{trans('message.SelectImage')}} </span>
                                            <span class="fileinput-exists"> {{trans('message.Change')}} </span>
                                            <input type="file" name="other_image">
                                        </span>
                                                <a href="#" class="btn default btn-danger fileinput-exists" data-dismiss="fileinput"> {{trans('message.Remove')}}  </a>
                                            </div>
                                            <span class="error">{!! $errors->first('other_image') !!}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                            </div>
                            <div class="form-actions">
                                <div class="col-md-offset-6 col-md-9">
                                    <button class="btn blue btn-info" type="submit">{{trans('message.Save')}} </button>
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
            $('#school, #viewSchool').addClass('active');
            $('#school').addClass('open');

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


