@extends('Admin::layouts.master')
@section('title', 'Edit Scientific Term/Rule')
@section('pageTitle', 'Edit Scientific Term/Rule')

@section('menuLink')
    <ol class="breadcrumb">
        <li>Edit Scientific Term/Rule</li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>Edit Scientific Term/Rule</li>
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
                    <h4 class="panel-title">Edit Scientific Term/Rule</h4>
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
                            @foreach($scientificTermRule as $key => $value)
                                <input type="hidden" class="form-control" name="scientific_term_id" value="{{$value->scientific_terms_id}}">
                                <input type="hidden" class="form-control" name="scientific_rule_id" value="{{$value->scientific_rule_id}}">

                            @endforeach

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Scientific Term</label>
                                <div class="col-sm-4">
                                    @foreach($scientificTermRule as $key => $value)
                                    <input type="text" class="form-control" name="scientific_term" value="{{$value->scientific_term}}">
                                    @endforeach
                                    <span class="error">{!! $errors->first('scientific_term') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Scientific Rule</label>
                                <div class="col-sm-4">
                                    @foreach($scientificTermRule as $key => $value)
                                        <input type="text" class="form-control" name="scientific_rule" value="{{$value->scientific_rule}}">
                                    @endforeach
                                    <span class="error">{!! $errors->first('scientific_rule') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>


                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn blue btn-info" type="submit">Update Scientific Term/Rule</button>
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
