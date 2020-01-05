@extends('Admin::layouts.master')
@section('title', 'Manage Term List')
@section('pageTitle', 'Manage Topic Terms List')

@section('menuLink')
    <ol class="breadcrumb">
        <li>
            <a href="/manage-school-course" style="color:#4e5e6a; text-decoration: none;">
                {{trans('message.SchoolCourse')}}
            </a>
        </li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>
            <a href="/manage-school-course" style="color:#4e5e6a; text-decoration: none;">
                {{trans('message.ViewSchoolCourse')}}
            </a>
        </li>
        <li class="active"></li>
    </ol>
    <ol class="breadcrumb">
        <li>
            <a href="/manage-topic-list/{{$schoolId}}/{{$stageId}}/{{$courseId}}" style="color:#4e5e6a; text-decoration: none;">
                {{trans('message.ViewTopicList')}}
            </a>
        </li>
        <li class="active"></li>
    </ol>
    <ol class="breadcrumb">
        <li>  {{trans('message.ViewTermList')}}</li>
    </ol>
@endsection


@section('head')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <style>

        /*th:nth-child(1), th:nth-child(2), th:nth-child(3) {*/
            /*text-align: center !important;*/
        /*}*/

        /*td:nth-child(1), td:nth-child(2) {*/
            /*text-align: right !important;*/
        /*}*/

        /*td:nth-child(3) {*/
            /*text-align: right !important;*/
        /*}*/

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <h2> {{trans('message.ScientificRulesandScientificTermsList')}}</h2><br>
                    <table id="termList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.Links&files')}}</th>
                            <th>{{trans('message.TopicScientificRules')}}</th>
                            <th>{{trans('message.TopicScientificTerms')}}</th>
                            <th>{{trans('message.Action')}}</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div id="term_utube" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.PleaseCopy/PasteYoutubeLink')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="term_utube_file" value="term_utube_file">

                        <input type="hidden" name="TopicTermRuleId" value="">

                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm" name="term_utube_link">                                </div>
                                </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn blue btn-info" type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal for Semester A MsWord-->
    <div id="term_simpleLink" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.PleaseCopy/PasteSimpleLink')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <input type="hidden" name="term_simpleLink_file" value="term_simpleLink_file">

                        <input type="hidden" name="TopicTermRuleId" value="">

                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm" name="term_simple_link">                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn blue btn-info" type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div id="term_ppt" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadpptFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="term_ppt">
                        <input type="hidden" name="TopicTermRuleId" value="">
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
                        <button class="btn blue btn-info" type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div id="term_msword" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadMicrosoftWordFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="term_msword">
                        <input type="hidden" name="TopicTermRuleId" value="">
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
                        <button class="btn blue btn-info" type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal for Semester A MsWord-->
    <div id="term_pdf" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('message.UploadPdfFile')}}</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px 0px 0px 150px !important;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="fileType" value="term_pdf">
                        <input type="hidden" name="TopicTermRuleId" value="">
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
                        <button class="btn blue btn-info" type="submit">{{trans('message.Upload')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>





@endsection

@section('bodyScript')
    <?php
    echo '<script> var schoolId = ' . $schoolId . '; var stageId = ' . $stageId . '; var courseId = ' . $courseId . '; var topicId = ' . $topicId . '; </script>';
    ?>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            //for activate the side menu
            $('#schoolCourse, #viewSchoolCourse').addClass('active');
            $('#schoolCourse').addClass('open');

            //It is ajax function which added a csrf token in meta tag of view page
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#termList').DataTable({
                processing: true,
                serverSide: true,
                "scrollX": true,
                "ajax": {
                    url: "/school-course-ajax-handler",
                    type: 'POST',
                    data: {
                        method: 'allTermList',
                        schoolId: schoolId,
                        stageId: stageId,
                        courseId: courseId,
                        topicId: topicId,
                    }
                },
                columns: [
                    {data: 'files', name: 'files', orderable: false, searchable: false},
                    {data: 'scientific_rule', name: 'scientific_rule.scientific_rule'},
                    {data: 'scientific_term', name: 'scientific_terms.scientific_term'},
                    {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}

                ],
                "order": [[2, 'asc']]
            });


            $(document.body).on('click', '.file', function () {
                //alert("fffffffffffffffff");
                $("input[name=TopicTermRuleId]").val($(this).attr('data-topicTermRuleId'))
            });



            $(document.body).on('click', '.delete-topicScientificTermRule', function () {
                var obj = $(this);
                var dataTopicScientificTermRuleId = $(this).attr('data-topicScientificTermRuleId');

                // alert(coursesRelationId);
                if (confirm("<?php echo trans('message.DoyouwanttodeletethisTopicScientificTerm/Rule!') ?>") == true) {
                    $.ajax({
                        url: '/school-course-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'deleteTopicScientificTermRule',
                            dataTopicScientificTermRuleId: dataTopicScientificTermRuleId,
                        },
                        success: function (response) {
                            if (response) {
                                toastr[response['status']](response['msg']);
                                $('#termList').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            });

        });
    </script>

@endsection

