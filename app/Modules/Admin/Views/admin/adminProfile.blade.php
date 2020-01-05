@extends('Admin::layouts.master')



@section('title')
    {{trans('message.Profile')}}
@endsection

@section('pageTitle')
    {{trans('message.Profile')}}
@endsection

@section('menuLink')
    <ol class="breadcrumb">
        <li>{{trans('message.Profile')}}</li>
    </ol>
@endsection

@section('head')
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/custom/components-rounded.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="list-group row list-group-icons">
                <li class="col-md-3">
                    <span class="list-group-item">
                        <i class="glyph-icon font-red icon-user"></i>
                        {{trans('message.PersonalInformation')}}
                    </span>
                </li>
            </ul>
            <div class="panel panel-white">
                <div class="panel-body">
                    @if(session('status'))
                        <div class="alert {{(session('status')== 'error'? 'alert-danger' : 'alert-success')}}">
                            <span><?php echo session('msg'); ?> </span>
                        </div>
                    @endif
                    @if(isset($status))
                        <div class="alert {{($status == 'error'? 'alert-danger' : 'alert-success')}}">
                            <span>{{$msg}}</span>
                        </div>
                    @endif
                    <form class="form-horizontal" method="post" enctype="multipart/form-data" file="true">
                        {{ csrf_field() }}
                        <div class="tab-content">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> {{trans('message.Name')}}</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="name" value="@if(old('name')){{old('name')}}@else{{$adminData->name}}@endif ">
                                            <span class="error">{!! $errors->first('name') !!}</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{trans('message.Email')}}</label>
                                        <div class="col-sm-4">
                                            <span class="form-control" style="cursor: not-allowed;">{{$adminData->email}}</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{trans('message.ProfileImage')}}</label>
                                        <div class="col-sm-4">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"
                                                     style="width: 200px; height: 150px;">
                                                    @if($adminData->profilepic !='')
                                                        <img src="{{$adminData->profilepic}}" alt="Profile Pic"/>
                                                    @else
                                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"/>
                                                    @endif
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail">
                                                </div>
                                                <div>
                                                    <span class="btn default btn-info btn-file">
                                                        <span class="fileinput-new"> {{trans('message.SelectImage')}} </span>
                                                        <span class="fileinput-exists">{{trans('message.Change')}}</span>
                                                        <input type="file" name="profile_image" accept="image/*">
                                                    </span>
                                                    <a href="#" class="btn default btn-danger fileinput-exists"
                                                       data-dismiss="fileinput">
                                                        {{trans('message.Remove')}} </a>
                                                </div>
                                                <span class="error">{!! $errors->first('profile_image') !!}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-actions" align="center">
                                <button type="submit" class="btn btn-success" style="width: 200px;">{{trans('message.Save')}}</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="reset" class="btn btn-default" style="width: 100px;">{{trans('message.Reset')}}</button>
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
            var status = "info";
            @if(!empty($msg))
                    @if($status == 'success')
                    status = "success";
            @elseif($status != 'success')
                    status = "error";
            @endif
                    toastr[status]("{{$msg}}");
            @endif
        });
    </script>
@endsection
