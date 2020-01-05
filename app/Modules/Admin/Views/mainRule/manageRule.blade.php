@extends('Admin::layouts.master')

@section('title')
    {{trans('message.ManageRule')}}
@endsection

@section('pageTitle')
    {{trans('message.ManageRule')}}
@endsection

@section('menuLink')
    <ol class="breadcrumb">
        <li>{{trans('message.MainRule')}}</li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>{{trans('message.ViewRule')}}</li>
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
                    <h2>{{trans('message.MainRuleList')}}</h2><br>
                    <table id="ruleList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.RuleNo')}}</th>
                            <th>{{trans('message.RuleName')}}</th>
                            {{--<th>{{trans('message.TermName')}}</th>--}}
                            {{--<th>{{trans('message.TopicName')}}</th>--}}
                            {{--<th>{{trans('message.CourseName')}}</th>--}}
                            {{--<th>{{trans('message.SchoolName')}}</th>--}}
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
            $('#courseScientificRule, #viewcourseScientificRule').addClass('active');
            $('#viewcourseScientificRule').addClass('open');

            //It is ajax function which added a csrf token in meta tag of view page
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#ruleList').DataTable({
                processing: true,
                serverSide: true,
                "scrollX": true,
                "language": {
                    "url": "/lang/pagination/datatables"
                },
                "ajax": {
                    url: "/rule-ajax-handler",
                    type: 'POST',
                    data: {
                        method: 'allRuleList',
                    }
                },
                columns: [
                    {data: 'rownum', name: 'rownum'},
                    {data: 'scientific_rule', name: 'scientific_rule.scientific_rule'},
//                    {data: 'scientific_term', name: 'scientific_terms.scientific_term'},
//                    {data: 'topic_name', name: 'topic.topic_name'},
//                    {data: 'course_name', name: 'courses.course_name'},
//                    {data: 'schoolName', name: 'schools.name'},
//                    {data: 'name', name: 'teaching_stage.name'},
                    {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                ]
            })

            $(document.body).on('click', '.delete-rule', function () {
                var obj = $(this);
                var dataruleId = $(this).attr('data-ruleId');
                if (confirm("Do you want to delete this Main Rule!") == true) {
                    $.ajax({
                        url: '/rule-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'deleteMainrule',
                            dataruleId: dataruleId,
                        },
                        success: function (response) {
                            if (response) {
                                toastr[response['status']](response['msg']);
                                $('#ruleList').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection

