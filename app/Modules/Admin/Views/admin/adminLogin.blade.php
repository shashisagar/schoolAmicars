<!DOCTYPE html>
<html>
<head>
    <title>{{trans('message.MySchoolApp')}} || {{trans('message.AdminPanel')}}</title>
    @include('Admin::layouts.headContent')
</head>
<body class="page-login">
<main class="page-content">
    <div class="page-inner bg-color">
        <div id="main-wrapper">
            <div class="row" style="    margin-top: 10%;">
                <div class="col-md-3 center">
                    <div class="login-box">
                        <a href="/" class="logo-name text-lg text-center"><img src="/assets/images/logo.png" width="75px"></a>
                        @if ($errors->first('errMsg')!= NULL)
                            <div class="alert alert-danger">
                                {!! $errors->first('errMsg') !!}
                            </div>
                        @endif
                        <p class="text-center m-t-md">{{trans('message.Please_login_into_your_account')}}</p>
                        <span class="error"></span>
                        <form class="m-t-md" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input class="form-control" placeholder="Email" name="email">
                                <span class="error">{!! $errors->first('email') !!}</span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                                <span class="error">{!! $errors->first('password') !!}</span>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">{{trans('message.Login')}}</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- Main Wrapper -->
    </div>
    <!-- Footer -->
    <div class="row">
        <div class="col-md-3 center">
            <p class="text-center m-t-xs text-sm" style="color:#fff;">{{date('Y')}} &copy; {{trans('message.MySchoolApp')}}</p>
        </div>
    </div>
</main>
@include('Admin::layouts.bodyCommonScripts')

</body>
</html>