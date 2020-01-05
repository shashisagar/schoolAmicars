@extends('Admin::layouts.master')


@section('title')
    {{trans('message.ManageTerm')}}
@endsection

@section('pageTitle')
    {{trans('message.ManageMainTerm')}}
@endsection

@section('menuLink')
    <ol class="breadcrumb">
        <li>{{trans('message.MainTerm')}}</li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>{{trans('message.ViewTerm')}}</li>
    </ol>
@endsection

@section('head')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <style>

        /*th:nth-child(1), th:nth-child(2), th:nth-child(3), th:nth-child(4),*/
        /*th:nth-child(5), th:nth-child(6), th:nth-child(7), th:nth-child(8){*/
            /*text-align: center !important;*/
        /*}*/

        /*td:nth-child(1), td:nth-child(4), td:nth-child(5),*/
        /*td:nth-child(7), td:nth-child(8){*/
            /*text-align: center !important;*/
        /*}*/

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <h2>{{trans('message.MainTermList')}}</h2><br>
                    <table id="termList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.TermNo')}}</th>
                            <th>{{trans('message.TermName')}}</th>
                            <th>{{trans('message.RuleName')}}</th>
                            <th>{{trans('message.TopicName')}}</th>
                            <th>{{trans('message.CourseName')}}</th>
                            <th>{{trans('message.SchoolName')}}</th>
                            {{--<th>{{trans('message.TeachingStage')}}</th>--}}
                            <th>{{trans('message.Action')}}</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('bodyScript')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            //for activate the side menu
            $('#courseScientificTerm, #viewcourseScientificTerm').addClass('active');
//            $('#addcourseScientificTerm').addClass('open');

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

                "language": {
                    "url": "/lang/pagination/datatables"
                },
                "ajax": {
                    url: "/term-ajax-handler",
                    type: 'POST',
                    data: {
                        method: 'allTermList',
                    }
                },
                columns: [
                    {data: 'rownum', name: 'rownum'},
                    {data: 'scientific_term', name: 'scientific_terms.scientific_term'},

                    {data: 'scientific_rule', name: 'scientific_rule.scientific_rule'},

                    {data: 'topic_name', name: 'topic.topic_name'},

                    {data: 'course_name', name: 'courses.course_name'},

                    {data: 'schoolName', name: 'schools.name'},

                    {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                ]
            })



            $(document.body).on('click', '.delete-term', function () {
                var obj = $(this);
                var datatermId = $(this).attr('data-termId');
                if (confirm("<?php echo trans('message.DoyouwanttodeletethisMainTerm!') ?>") == true) {
                    $.ajax({
                        url: '/term-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'deleteMainterm',
                            datatermId: datatermId,
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

