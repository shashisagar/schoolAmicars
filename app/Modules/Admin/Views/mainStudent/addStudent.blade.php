@extends('Admin::layouts.master')



@section('title')
    {{trans('message.AddMainStudent')}}
@endsection

@section('pageTitle')
    {{trans('message.AddMainStudent')}}
@endsection


@section('menuLink')
    <ol class="breadcrumb">
        <li><a href="/manage-teacher" style="color:rgb(34,186,160); text-decoration: none;">{{trans('message.ViewMainStudent')}}</a></li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>{{trans('message.AddMainStudent')}}</li>
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
                    <h4 class="panel-title">{{trans('message.AddMainStudent')}}</h4>
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
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('message.Name')}}</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                    <span class="error">{!! $errors->first('name') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('message.Email')}}</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="email" value="{{old('email')}}">
                                    <span class="error">{!! $errors->first('email') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('message.SelectSchool')}}</label>
                                <div class="col-sm-4">
                                    <select class="js-example-responsive form-control" name="school">
                                        <option value="">--{{trans('message.Select')}}--</option>
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
                                <label class="col-sm-2 control-label">{{trans('message.Password')}}</label>

                                <div class="col-sm-4">
                                    <input type="password" class="form-control"
                                           name="password"
                                           value="{{old('password')}}">
                                    <span class="error">{!! $errors->first('password') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('message.RetypeNewPassword')}}</label>

                                <div class="col-sm-4">
                                    <input type="password" class="form-control"
                                           name="retype_password"
                                           value="{{ old('retype_password') }}">
                                    <span class="error">{!! $errors->first('retype_password') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn blue btn-info" type="submit">{{trans('message.Add')}}</button>
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
@endsection
