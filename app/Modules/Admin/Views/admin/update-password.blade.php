@extends('Admin::layouts.master')
@section('title', 'Update Password')
@section('pageTitle', 'Update Password')

@section('menuLink')
    <ol class="breadcrumb">
        <li>{{trans('message.UpdatePassword')}}</li>
    </ol>
@endsection

@section('head')
    <link href="/assets/css/custom/components-rounded.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <ul class="list-group row list-group-icons">
                <li class="col-md-3">
                    <span class="list-group-item">
                        <i class="glyph-icon font-red icon-lock"></i>
                        {{trans('message.SecurityInformation')}}
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
                    <form class="form-horizontal" method="post">
                        {{ csrf_field() }}
                        <div class="tab-content">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> {{trans('message.OldPassword')}}</label>

                                        <div class="col-sm-4">
                                            <input type="password" class="form-control" id="old_password"
                                                   name="old_password"
                                                   value="{{old('old_password')}}">
                                            <span class="error">{!! $errors->first('old_password') !!}</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> {{trans('message.NewPassword')}}</label>

                                        <div class="col-sm-4">
                                            <input type="password" class="form-control" id="new_password"
                                                   name="new_password"
                                                   value="{{old('new_password')}}">
                                            <span class="error">{!! $errors->first('new_password') !!}</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{trans('message.RetypeNewPassword')}}</label>

                                        <div class="col-sm-4">
                                            <input type="password" class="form-control" id="retype_password"
                                                   name="retype_password"
                                                   value="{{ old('retype_password') }}">
                                            <span class="error">{!! $errors->first('retype_password') !!}</span>
                                        </div>
                                    </div>

                                    <div class="form-actions" align="center">
                                        <button type="submit" class="btn btn-success">{{trans('message.UpdatePassword')}}</button>
                                    </div>
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
