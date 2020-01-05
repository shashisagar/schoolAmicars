@extends('Admin::layouts.master')
@section('title')
    {{trans('message.ManageSchoolCourse')}}
@endsection

@section('pageTitle')
    {{trans('message.ManageSchoolCourse')}}
@endsection


@section('menuLink')
    <ol class="breadcrumb">
        <li>{{trans('message.SchoolCourse')}}</li>
        <span class="userDefineArrow"></span>
    </ol>

    <ol class="breadcrumb">
        <li>{{trans('message.ViewSchoolCourse')}}</li>
    </ol>

@endsection

@section('head')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <style>
        th:nth-child(1), th:nth-child(2), th:nth-child(3), th:nth-child(4),
        th:nth-child(5) {
            text-align: center !important;
        }

        /*td:nth-child(1), td:nth-child(2), td:nth-child(3){*/
        /*text-align: right !important;*/
        /*}*/

        td:nth-child(4), td:nth-child(5) {
            text-align: center !important;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <h2>{{trans('message.SchoolCourseList')}}</h2><br>

                    @if(Auth::user()->role == 1)
                        <div class="col-sm-2"><h>{{trans('message.SchoolName')}}</h></div>
                        <div class="col-sm-4">
                            <select class="js-example-responsive form-control" name="school" id="myschool">
                                <option value="">--{{trans('message.Select')}}--</option>
                                @if(!empty($schoolList))
                                    @foreach($schoolList as $key => $value)
                                        <option @if(old('school')== $value->schools_id) selected
                                                @endif value="{{$value->schools_id}}">{{$value->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif
                    <br><br>
                    <table id="schoolCourseList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.SchoolName')}}</th>
                            <th>{{trans('message.SemesterA')}}</th>
                            <th>{{trans('message.SemesterB')}}</th>
                            <th>{{trans('message.TeachingStage')}}</th>
                            <th>{{trans('message.Action')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--Topic Model with term button,youtube,simple link,ppt,msword, and pdf model--}}

    <div id="addTopicDialog" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content topiclist">

                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">

                    <div class="modal-header1">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        {{--<h4 class="modal-title">{{trans('message.TopicList')}}</h4>--}}
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">

                                    <h1 id="add_topic_button" style="float:right;"></h1>

                                    <h1 id="course_name"></h1>
                                    <p>{{trans('message.CourseTopicList')}}</p><br>
                                    <table id="topicListModel" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>{{trans('message.Links&files')}}</th>
                                            <th>{{trans('message.TopicName')}}</th>
                                            <th>{{trans('message.CourseTopicNumber')}}</th>
                                            {{--<th>{{trans('message.Action')}}</th>--}}
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>


                        <script>
                            $(document).on("click", ".open-AddTopicDialog", function () {
                                //alert("yyyyyyyyyyyyyyyyy");
                                var schoolId = $(this).data('id');

                                var stageId = $(this).data('ts');
                                var courseId = $(this).data('course');

                              //  alert(courseId);

                                $('#topicListModel').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    "scrollX": true,
                                    "bDestroy": true,
                                    "language": {
                                        "url": "/lang/pagination/datatables"
                                    },
                                    "ajax": {
                                        url: "/school-course-ajax-handler",
                                        type: 'POST',
                                        data: {
                                            method: 'allTopicList',
                                            schoolId: schoolId,
                                            stageId: stageId,
                                            courseId: courseId,
                                        }
                                    },
                                    columns: [
                                        {data: 'files', name: 'files', orderable: false, searchable: false},
                                        {data: 'topic_name', name: 'topic_name'},
                                        {data: 'rownum', name: 'rownum'},
//                                        {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                                    ],
                                    "order": [[2, 'asc']]
                                });

                                $(document.body).on('click', '.file', function () {
                                    //alert("fffffffffffffffff");
                                    $("input[name=CourseTopicId]").val($(this).attr('data-topicId'))
                                });
                            });
                        </script>


                        <script>
                            $(document).on("click", ".open-AddTopicDialog", function () {
                                var courseId = $(this).data('course');

                                $.ajax({
                                    type: "POST",
                                    url: 'topic_course_name',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        'courseId': courseId,

                                    },
                                    dataType: "json",
                                    success: function (data) {

                                        document.getElementById("course_name").innerHTML = data[0];
                                        document.getElementById("add_topic_button").innerHTML = '<button type="button" class="open-AddBookDialog1 btn btn-primary" data-toggle="modal" data-target="#addNewTopic" data-si='+data[1]+' data-ci='+data[2]+'>{{trans('message.AddTopic')}}</button>';

//                                        data-id='. $topicList->schools_id.' data-course='. $topicList->courses_id.' data-ts='. $topicList->teaching_stage_id.' data-ti='. $topicList->topic_id.'  class="open-AddTermDialog" href="#addTermDialog">
                                    },
                                });

                            });
                        </script>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <div id="addNewTopic" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content topic">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{trans('message.AddTopic')}}</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="post" role="form" id="add_new_topic">

                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <input type="hidden" name="data-si" id="dataSi" value="">

                        <input type="hidden" name="data-ci" id="dataCi" value="">

                        <div class="form-group">
                            <label class="col-sm-4 control-label"
                                    for="topic">{{trans('message.TopicName')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                       id="topic" name="topic" placeholder="Topic"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info btn-lg" style="float:right;">{{trans('message.AddTopic')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-info btn-lg" data-dismiss="modal">Close</button>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>






    <div id="topic_utube" class="modal fade" role="dialog">

        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data"
                      id="topic_utube_upload">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.PleaseCopy/PasteYoutubeLink')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="utube_file" value="utube_link1">
                        <input type="hidden" name="CourseTopicId" value="">

                        <div class="form-body">

                            <div id="form-errors"></div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm" name="utube_link"></div>
                                </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                       <a href="#" id="utube_topic_file_link_download">download & watch</a>


                        <button class="btn blue btn-info" type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal for Semester A MsWord-->
    <div id="topic_simpleLink" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8"
                      enctype="multipart/form-data" id="topic_link_upload">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.PleaseCopy/PasteSimpleLink')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <input type="hidden" name="simpleLink_file" value="simpleLink_file">

                        <input type="hidden" name="CourseTopicId" value="">


                        <div class="form-body">
                            <div id="form-errors-simpleLink"></div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm"
                                           name="topic_simple_link"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" id="simpleLink_topic_file_link_download">download & watch</a>


                        <button class="btn blue btn-info"
                                type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div id="topic_ppt" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8"
                      enctype="multipart/form-data" id="topic_ppt_upload">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadpptFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="topic_ppt">
                        <input type="hidden" name="CourseTopicId" value="">
                        <div class="form-body">
                            <div id="form-errors-ppt"></div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="btn btn-file" name="upload_file">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <a href="#" id="ppt_topic_file_link_download">download & watch</a>



                        <button class="btn blue btn-info"
                                type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div id="topic_msword" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8"
                      enctype="multipart/form-data" id="topic_word_upload">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadMicrosoftWordFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="topic_msword">
                        <input type="hidden" name="CourseTopicId" value="">
                        <div class="form-body">
                            <div id="form-errors-word"></div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="btn btn-file" name="upload_file">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <a href="#" id="word_topic_file_link_download">download & watch</a>

                        <button class="btn blue btn-info"
                                type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal for Semester A MsWord-->
    <div id="topic_pdf" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8"
                      enctype="multipart/form-data" id="topic_pdf_upload">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadPdfFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="topic_pdf">
                        <input type="hidden" name="CourseTopicId" value="">
                        <div class="form-body">

                            <div id="form-errors-pdf"></div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="btn btn-file" name="upload_file">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <a href="#" id="pdf_topic_file_link_download">download & watch</a>
                        <button class="btn blue btn-info"
                                type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{--Term Model with term button,youtube,simple link,ppt,msword, and pdf model--}}

    <div id="addTermDialog" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content termlist">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal-header1">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        {{--<h4 class="modal-title">{{trans('message.TermList')}}</h4>--}}
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <h1 id="add_term_button" style="float:right;"></h1>
                                    <h1 id="topic_name"></h1>
                                    <h2>{{trans('message.CourseTermList')}}</h2><br>
                                    <table id="termListModel" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>{{trans('message.Links&files')}}</th>
                                            <th>{{trans('message.TopicScientificRules')}}</th>
                                            <th>{{trans('message.TopicScientificTerms')}}</th>
                                            {{--<th>{{trans('message.Action')}}</th>--}}
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>


                        <script>
                            $(document).on("click", ".open-AddTermDialog", function () {
                                //alert("yyyyyyyyyyyyyyyyy");
                                var schoolId = $(this).data('id');
                                //alert(schoolId);
                                var courseId = $(this).data('course');
                               // var courseId = $(this).data('ts');
                                var topicId = $(this).data('ti');

                                $('#termListModel').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    "scrollX": true,
                                    "bDestroy": true,
                                    "language": {
                                        "url": "/lang/pagination/datatables"
                                    },
                                    "ajax": {
                                        url: "/school-course-ajax-handler",
                                        type: 'POST',
                                        data: {
                                            method: 'allTermList',
                                            schoolId: schoolId,
                                           // stageId: stageId,
                                            courseId: courseId,
                                            topicId: topicId,
                                        }
                                    },
                                    columns: [
                                        {data: 'files', name: 'files', orderable: false, searchable: false},
                                        {data: 'scientific_rule', name: 'scientific_rule.scientific_rule'},
                                        {data: 'scientific_term', name: 'scientific_terms.scientific_term'},
//                                        {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}

                                    ],
                                    "order": [[2, 'asc']]
                                });

                                $(document.body).on('click', '.file', function () {
                                    //alert("fffffffffffffffff");
                                    $("input[name=TopicTermRuleId]").val($(this).attr('data-topicTermRuleId'))
                                });

                            });

                            $(document).on("click", ".open-AddTermDialog", function () {
                                var topicId = $(this).data('ti');

                                $.ajax({
                                    type: "POST",
                                    url: 'termRule_topic_name',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        'topicId': topicId,

                                    },
                                    dataType: "json",
                                    success: function (data) {

                                        document.getElementById("topic_name").innerHTML = data[0];
                                        document.getElementById("add_term_button").innerHTML = '<button type="button" class="open-AddTermDialog1 btn btn-primary" data-toggle="modal" data-target="#addNewTerm" data-tsi='+data[1]+' data-tci='+data[2]+' data-tti='+data[3]+'>{{trans('message.AddTerm')}}</button>';


                                    },
                                });

                            });

                        </script>

                    </div>

                </form>


            </div>


        </div>

    </div>




    <div id="addNewTerm" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content term">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{trans('message.AddTerm')}}</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="post" role="form" id="add_new_term">

                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <input type="hidden" name="data-tsi" id="datatSi" value="">

                        <input type="hidden" name="data-tci" id="datatCi" value="">

                        <input type="hidden" name="data-tti" id="datatTi" value="">



                      

                       

                        <div class="form-group">
                            <label class="col-sm-4 control-label"
                                   for="topic">{{trans('message.TermName')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                       id="term" name="term" placeholder="Term"/>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label">{{trans('message.SelectRule')}}</label>
                            <div class="col-sm-8">
                                <select class="js-example-responsive form-control" name="rule" id="dataRi">
                                    <option value="">--{{trans('message.Select')}}--</option>
                                    @if(!empty($ruleList))
                                        @foreach($ruleList as $key => $value)
                                            <option @if(old('school')== $value->scientific_rule_id) selected
                                                    @endif value="{{$value->scientific_rule_id}}">{{$value->scientific_rule}}</option>
                                        @endforeach
                                    @endif
                                </select>

                                {{--<span class="error">{!! $errors->first('scientificRule') !!}</span>--}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info btn-lg" style="float:right;">{{trans('message.AddTerm')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-info btn-lg" data-dismiss="modal">Close</button>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

    <div id="term_utube" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8"
                      enctype="multipart/form-data" id="term_utube_upload">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.PleaseCopy/PasteYoutubeLink')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="term_utube_file" value="term_utube_file">

                        <input type="hidden" name="TopicTermRuleId" value="">

                        <div class="form-body">
                            <div id="term-errors-utube"></div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm"
                                           name="term_utube_link"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <div id="utube_rule_file_link_download"></div>
                        <button class="btn blue btn-info"
                                type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal for Semester A MsWord-->
    <div id="term_simpleLink" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8"
                      enctype="multipart/form-data" id="term_link_upload">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.PleaseCopy/PasteSimpleLink')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <input type="hidden" name="term_simpleLink_file"
                               value="term_simpleLink_file">

                        <input type="hidden" name="TopicTermRuleId" value="">

                        <div class="form-body">
                            <div id="term-errors-simpleLink"></div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm"
                                           name="term_simple_link"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="simpleLink_rule_file_link_download"></div>
                        <button class="btn blue btn-info"
                                type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div id="term_ppt" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8"
                      enctype="multipart/form-data" id="term_ppt_upload">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadpptFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="term_ppt">
                        <input type="hidden" name="TopicTermRuleId" value="">
                        <div class="form-body">
                            <div id="term-errors-ppt"></div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="btn btn-file" name="upload_file">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="ppt_rule_file_link_download"></div>
                        <button class="btn blue btn-info"
                                type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div id="term_msword" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8"
                      enctype="multipart/form-data" id="term_word_upload">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadMicrosoftWordFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="term_msword">
                        <input type="hidden" name="TopicTermRuleId" value="">
                        <div class="form-body">
                            <div id="term-errors-word"></div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="btn btn-file" name="upload_file">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="word_rule_file_link_download"></div>
                        <button class="btn blue btn-info"
                                type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal for Semester A MsWord-->
    <div id="term_pdf" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8"
                      enctype="multipart/form-data" id="term_pdf_upload">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadPdfFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="term_pdf">
                        <input type="hidden" name="TopicTermRuleId" value="">
                        <div class="form-body">

                            <div id="term-errors-pdf"></div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="btn btn-file" name="upload_file">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <div id="pdf_rule_file_link_download"></div>
                        <button class="btn blue btn-info"
                                type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="pdf_a" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadPdfFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="pdf_a">
                        <input type="hidden" name="schoolCourseId" value="">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="btn btn-file" name="upload_file">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div> <a href="#" id="pdf_file_link_a_download">download & watch</a></div>

                        <button class="btn blue btn-info" type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Semester A MsWord-->
    <div id="msword_a" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadMicrosoftWordFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="msWord_a">
                        <input type="hidden" name="schoolCourseId" value="">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="btn btn-file" name="upload_file">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div> <a href="#" id="word_file_link_a_download">download & watch</a></div>

                        <button class="btn blue btn-info" type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal for Semester B PDF-->
    <div id="pdf_b" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadPdfFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="pdf_b">
                        <input type="hidden" name="schoolCourseId" value="">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="btn btn-file" name="upload_file">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div> <a href="#" id="pdf_file_link_b_download">download & watch</a></div>

                        <button class="btn blue btn-info" type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal for Semester B MsWord-->
    <div id="msword_b" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadMicrosoftWordFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="msWord_b">
                        <input type="hidden" name="schoolCourseId" value="">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="btn btn-file" name="upload_file">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div> <a href="#" id="word_file_link_b_download">download & watch</a></div>

                        <button class="btn blue btn-info" type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


@endsection

@section('bodyScript')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            //for activate the side menu
            $('#dashboard, #dashboard').addClass('active');
            $('#dashboard').addClass('open');

            //It is ajax function which added a csrf token in meta tag of view page
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#myschool").on('change', function(event){
                event.preventDefault();
                var schools_id = $(this).val();
                // alert(term_courses_id);

                findCourses(schools_id);
            });
            function findCourses(schools_id) {
                $('#schoolCourseList').DataTable({
                    processing: true,
                    serverSide: true,
                    "scrollX": true,
                    "bDestroy": true,
                    "language": {
                        "url": "/lang/pagination/datatables"
                    },
                    "ajax": {
                        url: "/school-course-ajax-handler",
                        type: 'POST',
                        data: {
                            method: 'allSchoolCourseList',
                            schools_id:schools_id
                        }
                    },
                    columns: [
                        {data: 'school_name', name: 'schools.name'},
                        {data: 'semesterA', name: 'coursesA.course_name', orderable: false},
                        {data: 'semesterB', name: 'coursesB.course_name', orderable: false},
                        {data: 'teaching_stage_name', name: 'teaching_stage.name'},
                        {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                    ],
                    "order": [[3, 'asc']]
                });
            }

            $('#schoolCourseList').DataTable({
                processing: true,
                serverSide: true,
                "scrollX": true,
                "language": {
                    "url": "/lang/pagination/datatables"
                },
                "ajax": {
                    url: "/school-course-ajax-handler",
                    type: 'POST',
                    data: {
                        method: 'allSchoolCourseList',
                    }
                },
                columns: [
                    {data: 'school_name', name: 'schools.name'},
                    {data: 'semesterA', name: 'coursesA.course_name', orderable: false},
                    {data: 'semesterB', name: 'coursesB.course_name', orderable: false},
                    {data: 'teaching_stage_name', name: 'teaching_stage.name'},
                    {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                ],
                "order": [[3, 'asc']]
            });

            $(document.body).on('click', '.file', function () {
                //alert("fffffffffffffffff");
                $("input[name=schoolCourseId]").val($(this).attr('data-coursesRelationId'))
            });


            $(document.body).on('click', '.delete-schoolCourse', function () {
                var obj = $(this);
                var coursesRelationId = $(this).attr('data-coursesRelationId');
                // alert(coursesRelationId);
                if (confirm("<?php echo trans('message.DoyouwanttodeletethisCourse/Teacher') ?>") == true) {
                    $.ajax({
                        url: '/school-course-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'deleteCourseTeacher',
                            coursesRelationId: coursesRelationId,
                        },
                        success: function (response) {
                            if (response) {
                                toastr[response['status']](response['msg']);
                                $('#schoolCourseList').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
    </script>

    <style>
        .inputfile {
            /* visibility: hidden etc. wont work */
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .inputfile:focus + label {
            /* keyboard navigation */
            outline: 1px dotted #000;
            outline: -webkit-focus-ring-color auto 5px;
        }

        .inputfile + label * {
            pointer-events: none;
        }

        @media screen and (min-width: 500px) {

            #addTopicDialog .modal-dialog {
                width: 49%;
                float:left;
                /*border:5px solid orange;*/
            }

            #addTermDialog .modal-dialog {
                width: 49%;
                float:right;
                /*border:5px solid red;*/
            }

            #topic_utube {
                top: 5%;
                right: 10%;
                width: 100%;
                outline: none;
            }

            .modal-footer a {
                float: left;
            }

        }

        .modal-content
        {
            border:5px solid rgb(77,182,172);
        }

        .modal-content.topiclist
        {
            border:5px solid rgb(213,0,249);
        }

        .modal-content.termlist
        {
            border:5px solid rgb(174,234,0);
        }

        .modal-content.term
        {
            border:5px solid rgb(225,104,109);
        }
        .modal-content.topic
        {
            border:5px solid rgb(225,104,109);
        }
    </style>

    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#add_new_topic').submit(function (event) {
                event.preventDefault();

                var topic=$("#topic").val();
                var dataSi=$("#dataSi").val();
                var dataCi=$("#dataCi").val();

                $.ajax({
                    type: "POST",
                    url: 'addNewTopicInCourse',
                    data: { topic: topic,dataSi:dataSi,dataCi:dataCi },
                    dataType: "json",

                    success: function (data) {
                       if(data[0]=='1')
                       {
                           $("#addNewTopic").modal('hide');
                           $('#topicListModel').DataTable({
                               processing: true,
                               serverSide: true,
                               "scrollX": true,
                               "bDestroy": true,
                               "language": {
                                   "url": "/lang/pagination/datatables"
                               },
                               "ajax": {
                                   url: "/school-course-ajax-handler",
                                   type: 'POST',
                                   data: {
                                       method: 'allTopicList',
                                       schoolId: dataSi,
//                                       stageId: stageId,
                                       courseId: dataCi,
                                   }
                               },
                               columns: [
                                   {data: 'files', name: 'files', orderable: false, searchable: false},
                                   {data: 'topic_name', name: 'topic_name'},
                                   {data: 'rownum', name: 'rownum'},
//                                        {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                               ],
                               "order": [[2, 'asc']]
                           });
                       }

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#form-errors').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>

   <script>
    $(document).on("click", ".open-AddBookDialog1", function () {
      var myschoolId = $(this).data('si');
      var courseId = $(this).data('ci');

      $(".modal-body #dataSi").val(myschoolId);
      $(".modal-body #dataCi").val(courseId);

    });
   </script>



    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#add_new_term').submit(function (event) {
                event.preventDefault();

                var term=$("#term").val();
                var dataRi=$("#dataRi").val();

               // alert(dataRi);

                var datatSi=$("#datatSi").val();
                var datatCi=$("#datatCi").val();
                var datatTi=$("#datatTi").val();


                $.ajax({
                    type: "POST",
                    url: 'addNewTermInTopic',
                    data: { term: term,dataRi:dataRi,datatSi:datatSi,datatCi:datatCi,datatTi:datatTi },
                    dataType: "json",

                    success: function (data) {
                        if(data[0]=='1')
                        {
                            $("#addNewTerm").modal('hide');
                            $('#termListModel').DataTable({
                                processing: true,
                                serverSide: true,
                                "scrollX": true,
                                "bDestroy": true,
                                "language": {
                                    "url": "/lang/pagination/datatables"
                                },
                                "ajax": {
                                    url: "/school-course-ajax-handler",
                                    type: 'POST',
                                    data: {
                                        method: 'allTermList',
                                        schoolId: datatSi,
                                        courseId: datatCi,
                                        topicId: datatTi,
                                    }
                                },
                                columns: [
                                    {data: 'files', name: 'files', orderable: false, searchable: false},
                                    {data: 'scientific_rule', name: 'scientific_rule.scientific_rule'},
                                    {data: 'scientific_term', name: 'scientific_terms.scientific_term'},
//                                        {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}

                                ],
                                "order": [[2, 'asc']]
                            });
                        }

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#form-errors').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>



    <script>
        $(document).on("click", ".open-AddTermDialog1", function () {
            var myschoolId = $(this).data('tsi');
            var courseId = $(this).data('tci');
            var topicId = $(this).data('tti');


           // alert(topicId);

            $(".modal-body #datatSi").val(myschoolId);
            $(".modal-body #datatCi").val(courseId);
            $(".modal-body #datatTi").val(topicId);

        });
    </script>














    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#topic_link_upload').submit(function (event) {
                // alert("ssssssssssssssssss");
                event.preventDefault();

                formData = new FormData($("#topic_link_upload")[0]);

                $.ajax({
                    type: "POST",
                    url: 'uploadTopicLink',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#link' + response.topic_id).attr('src', "/assets/images/simpleLink_color.png");

                        $("#topic_simpleLink").modal('hide');

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#form-errors-simpleLink').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>


    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#topic_ppt_upload').submit(function (event) {
                // alert("ssssssssssssssssss");
                event.preventDefault();

                formData = new FormData($("#topic_ppt_upload")[0]);

                $.ajax({
                    type: "POST",
                    url: 'uploadTopicPpt',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#ppt' + response.topic_id).attr('src', "/assets/images/ppt_color.png");

                        $("#topic_ppt").modal('hide');

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#form-errors-ppt').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#topic_word_upload').submit(function (event) {
                // alert("ssssssssssssssssss");
                event.preventDefault();

                formData = new FormData($("#topic_word_upload")[0]);

                $.ajax({
                    type: "POST",
                    url: 'uploadTopicWord',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#word' + response.topic_id).attr('src', "/assets/images/msword_color.png");

                        $("#topic_msword").modal('hide');

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#form-errors-word').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>


    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#topic_pdf_upload').submit(function (event) {
                // alert("ssssssssssssssssss");
                event.preventDefault();

                formData = new FormData($("#topic_pdf_upload")[0]);

                $.ajax({
                    type: "POST",
                    url: 'uploadTopicPdf',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#pdf' + response.topic_id).attr('src', "/assets/images/pdf_color.png");

                        $("#topic_pdf").modal('hide');

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#form-errors-pdf').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>



    <style>
        #form-errors {
            color: red;
        }
        #form-errors-simpleLink
        {
            color:red;
        }
        #form-errors-ppt
        {
            color:red;
        }
        #form-errors-word
        {
            color:red;
        }
        #form-errors-pdf
        {
            color:red;
        }
    </style>


    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#term_utube_upload').submit(function (event) {
                // alert("ssssssssssssssssss");
                event.preventDefault();

                formData = new FormData($("#term_utube_upload")[0]);

                $.ajax({
                    type: "POST",
                    url: 'uploadTermYouTube',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#utube' + response.scientific_term_per_topic_id).attr('src', "/assets/images/utube_color.png");

                        $("#term_utube").modal('hide');

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#term-errors-utube').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#term_link_upload').submit(function (event) {
                // alert("ssssssssssssssssss");
                event.preventDefault();

                formData = new FormData($("#term_link_upload")[0]);

                $.ajax({
                    type: "POST",
                    url: 'uploadTermLink',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#link' + response.scientific_term_per_topic_id).attr('src', "/assets/images/simpleLink_color.png");

                        $("#term_simpleLink").modal('hide');

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#term-errors-simpleLink').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>


    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#term_ppt_upload').submit(function (event) {
                // alert("ssssssssssssssssss");
                event.preventDefault();

                formData = new FormData($("#term_ppt_upload")[0]);

                $.ajax({
                    type: "POST",
                    url: 'uploadTermPpt',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#ppt' + response.scientific_term_per_topic_id).attr('src', "/assets/images/ppt_color.png");

                        $("#term_ppt").modal('hide');

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#term-errors-ppt').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#term_word_upload').submit(function (event) {
                // alert("ssssssssssssssssss");
                event.preventDefault();

                formData = new FormData($("#term_word_upload")[0]);

                $.ajax({
                    type: "POST",
                    url: 'uploadTermWord',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#word' + response.scientific_term_per_topic_id).attr('src', "/assets/images/msword_color.png");

                        $("#term_msword").modal('hide');

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#term-errors-word').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>


    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#term_pdf_upload').submit(function (event) {
                // alert("ssssssssssssssssss");
                event.preventDefault();

                formData = new FormData($("#term_pdf_upload")[0]);

                $.ajax({
                    type: "POST",
                    url: 'uploadTermPdf',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#pdf' + response.scientific_term_per_topic_id).attr('src', "/assets/images/pdf_color.png");

                        $("#term_pdf").modal('hide');

                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#term-errors-pdf').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>



    <script>
        $(document).on("click", "#mymsword_a", function() {
            var adminid = $(this).data('id');
            $.ajax({
                type: "POST",
                url: 'get_mswordfile',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'adminid': adminid,

                },
                dataType: "json",
                success: function (data) {
                    //alert(data[0]);


                    if(data[0]=='1')
                    {

                        document.getElementById("word_file_link_a_download").innerHTML="";

                    }
                    else {
                        document.getElementById("word_file_link_a_download").href = data[0];
                    }
//                    document.getElementById("word_file_link_a_download").innerHTML = data[0];


                },
            });





        });
    </script>


    <script>
        $(document).on("click", "#mymsword_b", function() {
            var mymsword_b = $(this).data('id');
            $.ajax({
                type: "POST",
                url: 'get_mswordfile_b',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'mymsword_b': mymsword_b,

                },
                dataType: "json",
                success: function (data) {
                    //alert(data[0]);


                    if(data[0]=='1')
                    {

                        document.getElementById("word_file_link_b_download").innerHTML="";

                    }
                    else {
                        document.getElementById("word_file_link_b_download").href = data[0];
                    }
//                    document.getElementById("word_file_link_a_download").innerHTML = data[0];


                },
            });





        });
    </script>


    <script>
        $(document).on("click", "#mypdf_a", function() {
            var mypdf_a = $(this).data('id');
            $.ajax({
                type: "POST",
                url: 'get_mypdf_a',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'mypdf_a': mypdf_a,

                },
                dataType: "json",
                success: function (data) {
                    //alert(data[0]);


                    if(data[0]=='1')
                    {

                        document.getElementById("pdf_file_link_a_download").innerHTML="";

                    }
                    else {
                        document.getElementById("pdf_file_link_a_download").href = data[0];
                    }
//                    document.getElementById("word_file_link_a_download").innerHTML = data[0];


                },
            });





        });
    </script>


    <script>
        $(document).on("click", "#mypdf_b", function() {
            var mypdf_b = $(this).data('id');
            $.ajax({
                type: "POST",
                url: 'get_mypdf_b',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'mypdf_b': mypdf_b,

                },
                dataType: "json",
                success: function (data) {
                    //alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("pdf_file_link_b_download").innerHTML="";
                    }
                    else {
                        document.getElementById("pdf_file_link_b_download").href = data[0];
                    }
//                    document.getElementById("word_file_link_a_download").innerHTML = data[0];

                },
            });
        });
    </script>



    <script>
        $(document).on("click", ".file", function() {
            var youtubetopicId = $(this).data('id');
            //alert(youtubetopicId);

            $.ajax({
                type: "POST",
                url: 'get_topic_utube_link',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'youtubetopicId': youtubetopicId,

                },
                dataType: "json",
                success: function (data) {

                    //alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("utube_topic_file_link_download").innerHTML="";
                    }
                    else {
                        document.getElementById("utube_topic_file_link_download").innerHTML = '<a href='+data[0]+' target="_blank">Watch</a>';
                    }

                },
            });
        });
    </script>



    <script>
        $(document).on("click", ".file", function() {
            var simplelinktopicId = $(this).data('id');
            //alert(youtubetopicId);

            $.ajax({
                type: "POST",
                url: 'get_topic_simple_link',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'simplelinktopicId': simplelinktopicId,

                },
                dataType: "json",
                success: function (data) {

                    //alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("simpleLink_topic_file_link_download").innerHTML="";
                    }
                    else {
                        document.getElementById("simpleLink_topic_file_link_download").innerHTML = '<a href='+data[0]+' target="_blank">Download & Watch</a>';
                    }

                },
            });
        });
    </script>


    <script>
        $(document).on("click", ".file", function() {
            var ppttopicId = $(this).data('id');
            //alert(youtubetopicId);

            $.ajax({
                type: "POST",
                url: 'get_topic_ppt_file',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ppttopicId': ppttopicId,

                },
                dataType: "json",
                success: function (data) {

                    //alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("ppt_topic_file_link_download").innerHTML="";
                    }
                    else {
                        document.getElementById("ppt_topic_file_link_download").innerHTML = '<a href='+data[0]+' target="_blank">View & Download</a>';
                    }

                },
            });
        });
    </script>


    <script>
        $(document).on("click", ".file", function() {
            var wordtopicId = $(this).data('id');
            //alert(youtubetopicId);

            $.ajax({
                type: "POST",
                url: 'get_topic_word_file',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'wordtopicId': wordtopicId,

                },
                dataType: "json",
                success: function (data) {

                    //alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("word_topic_file_link_download").innerHTML="";
                    }
                    else {
                        document.getElementById("word_topic_file_link_download").innerHTML = '<a href='+data[0]+' target="_blank">View & Download</a>';
                    }

                },
            });
        });
    </script>


     <script>
        $('#addNewTopic').on('hidden.bs.modal', function () {
            $(this).find("input,textarea,select").val('').end();
        });
        $('#addNewTerm').on('hidden.bs.modal', function () {
            $(this).find("input,textarea,select").val('').end();
        });

    </script>


    <script>
        $(document).on("click", ".file", function() {
            var pdftopicId = $(this).data('id');
            //alert(youtubetopicId);

            $.ajax({
                type: "POST",
                url: 'get_topic_pdf_file',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'pdftopicId': pdftopicId,

                },
                dataType: "json",
                success: function (data) {

                    //alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("pdf_topic_file_link_download").innerHTML="";
                    }
                    else {
                        document.getElementById("pdf_topic_file_link_download").innerHTML = '<a href='+data[0]+' target="_blank">View & Download</a>';
                    }

                },
            });
        });
    </script>


    <script>
        $(document).on("click", ".file", function() {
            var youtuberuleId = $(this).data('id');
            //alert(youtubetopicId);

            $.ajax({
                type: "POST",
                url: 'get_rule_utube_link',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'youtuberuleId': youtuberuleId,

                },
                dataType: "json",
                success: function (data) {

                   // alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("utube_rule_file_link_download").innerHTML="";
                    }
                    else {
                        document.getElementById("utube_rule_file_link_download").innerHTML = '<a href='+data[0]+' target="_blank">Watch</a>';
                    }

                },
            });
        });
    </script>



    <script>
        $(document).on("click", ".file", function() {
            var simplelinkruleId = $(this).data('id');
            //alert(youtubetopicId);

            $.ajax({
                type: "POST",
                url: 'get_rule_simple_link',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'simplelinkruleId': simplelinkruleId,

                },
                dataType: "json",
                success: function (data) {

                    //alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("simpleLink_rule_file_link_download").innerHTML="";
                    }
                    else {
                        document.getElementById("simpleLink_rule_file_link_download").innerHTML = '<a href='+data[0]+' target="_blank">Download & Watch</a>';
                    }

                },
            });
        });
    </script>


    <script>
        $(document).on("click", ".file", function() {
            var pptruleId = $(this).data('id');
            //alert(youtubetopicId);

            $.ajax({
                type: "POST",
                url: 'get_rule_ppt_file',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'pptruleId': pptruleId,

                },
                dataType: "json",
                success: function (data) {

                    //alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("ppt_rule_file_link_download").innerHTML="";
                    }
                    else {
                        document.getElementById("ppt_rule_file_link_download").innerHTML = '<a href='+data[0]+' target="_blank">View & Download</a>';
                    }

                },
            });
        });
    </script>


    <script>
        $(document).on("click", ".file", function() {
            var wordruleId = $(this).data('id');
            //alert(youtubetopicId);

            $.ajax({
                type: "POST",
                url: 'get_rule_word_file',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'wordruleId': wordruleId,

                },
                dataType: "json",
                success: function (data) {

                    //alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("word_rule_file_link_download").innerHTML="";
                    }
                    else {
                        document.getElementById("word_rule_file_link_download").innerHTML = '<a href='+data[0]+' target="_blank">View & Download</a>';
                    }

                },
            });
        });
    </script>


    <script>
        $(document).on("click", ".file", function() {
            var pdfruleId = $(this).data('id');
            //alert(youtubetopicId);

            $.ajax({
                type: "POST",
                url: 'get_rule_pdf_file',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'pdfruleId': pdfruleId,

                },
                dataType: "json",
                success: function (data) {

                    //alert(data[0]);
                    if(data[0]=='1')
                    {
                        document.getElementById("pdf_rule_file_link_download").innerHTML="";
                    }
                    else {
                        document.getElementById("pdf_rule_file_link_download").innerHTML = '<a href='+data[0]+' target="_blank">View & Download</a>';
                    }

                },
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            // $("#upload_form").on("submit", function(event){
            $('#topic_utube_upload').submit(function (event) {
                // alert("ssssssssssssssssss");
                event.preventDefault();
                formData = new FormData($("#topic_utube_upload")[0]);
                $.ajax({
                    type: "POST",
                    url: 'uploadTopicYouTube',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#utube' + response.topic_id).attr('src', "/assets/images/utube_color.png");

                        $("#topic_utube").modal('hide');



                    },
                    error: function (jqXhr) {

                        if (jqXhr.status === 400) {

                            var errors = jqXhr.responseJSON.errors; //this will get the errors response data.

                            errorsHtml = '<div><ul>';

                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></div>';

                            $('#form-errors').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                        }
                    }

                });


            });
        });
    </script>

    <style>
        #term-errors-utube {
            color: red;
        }
        #term-errors-simpleLink
        {
            color:red;
        }
        #term-errors-ppt
        {
            color:red;
        }
        #term-errors-word
        {
            color:red;
        }
        #term-errors-pdf
        {
            color:red;
        }
        .modal-header1 {
            border: 0 none;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            font-size: 14px;
            font-weight: 600;
            height: 21px;
            overflow: hidden;
            padding: 6px;
        }
        .mycustomclass { width: 250px;}
        .mycustomclass p { line-height: 2px !important;}
    </style>


@endsection
