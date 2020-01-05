@extends('Admin::layouts.master')



@section('title')
    {{trans('message.ManageMainTopics')}}
@endsection

@section('pageTitle')
    {{trans('message.ManageMainTopics')}}
@endsection


@section('menuLink')
    <ol class="breadcrumb">
        <li>{{trans('message.MainTopic')}}</li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>{{trans('message.ViewTopics')}}</li>
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
                    <h2>{{trans('message.MainTopicList')}}</h2><br>

                    @if(Auth::user()->role == 1)
                        <div class="col-sm-2">{{trans('message.SchoolName')}}</div>
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
                        <div class="col-sm-2">{{trans('message.CourseName')}}</div>
                        <div class="col-sm-4">
                            <select class="js-example-responsive form-control" name="course_name" id="courseList">
                                <option value="">--{{trans('message.Select')}}--</option>
                                {{--@if(!empty($allCourses))--}}

                                {{--@foreach($allCourses as $key => $value)--}}
                                {{--<option @if(old('school')== $value->courses_id) selected--}}
                                {{--@endif value="{{$value->courses_id}}">{{$value->course_name}}--}}
                                {{--</option>--}}
                                {{--@endforeach--}}
                                {{--@endif--}}
                            </select>
                            <span class="error">{!! $errors->first('course_name') !!}</span>
                        </div>
                        @else
                        <div class="col-sm-4">{{trans('message.CourseName')}}</div>
                        <div class="col-sm-4">
                            <select class="js-example-responsive form-control" name="course_name" id="courseList">
                                <option value="">--{{trans('message.Select')}}--</option>
                                @if(!empty($allCourses))
                                @foreach($allCourses as $key => $value)
                                <option @if(old('school')== $value->courses_id) selected
                                @endif value="{{$value->courses_id}}">{{$value->course_name}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <span class="error">{!! $errors->first('course_name') !!}</span>
                        </div>

                    @endif

                    <br><br>
                    <br>

                    <table id="topicList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.TopicNo')}}</th>
                            <th>{{trans('message.TopicName')}}</th>
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
            $('#courseTopic, #viewcourseTopic').addClass('active');
            $('#courseTopic').addClass('open');

            //It is ajax function which added a csrf token in meta tag of view page
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#courseList").on('change', function(event){
                event.preventDefault();
                var term_courses_id = $(this).val();
               // alert(term_courses_id);

                findCoursesTopic(term_courses_id);
            });
            function findCoursesTopic(term_courses_id){
                $('#topicList').DataTable({
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,
                    "scrollX": true,
                    "language": {
                        "url": "/lang/pagination/datatables"
                    },
                    "ajax": {
                        url: "/course-topic-list-details",
                        type: 'POST',
                        data: { term_courses_id: term_courses_id },
                    },
                    columns: [
                        {data: 'rownum', name: 'rownum'},
                        {data: 'topic_name', name: 'topic.topic_name'},
//                        {data: 'course_name', name: 'courses.course_name'},
//                        {data: 'schoolName', name: 'schools.name'},
//                        {data: 'name', name: 'teaching_stage.name'},
                        {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                    ]


                })

//                $.ajax({
//                    type: "GET",
//                    data: { term_courses_id: term_courses_id },
//                    url: "/topic-per-courses",
//                    success: function(res) {
//
//                        $("#allTopicList").html(res);
//
//                    }
//                });
            }



//            $('#topicList').DataTable({
//                processing: true,
//                serverSide: true,
//                "scrollX": true,
//                "ajax": {
//                    url: "/course-topic-ajax-handler",
//                    type: 'POST',
//                    data: {
//                        method: 'allTopicsList',
//                    }
//                },
//                columns: [
//                    {data: 'rownum', name: 'rownum'},
//                    {data: 'topic_name', name: 'topic.topic_name'},
//                    {data: 'course_name', name: 'courses.course_name'},
//                    {data: 'schoolName', name: 'schools.name'},
//                    {data: 'name', name: 'teaching_stage.name'},
//                    {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
//                ]
//            })



            $(document.body).on('click', '.delete-topic', function () {
                var obj = $(this);
                var topicId = $(this).attr('data-topicId');
                if (confirm("Do you want to delete this Topic!") == true) {
                    $.ajax({
                        url: '/delete-topics',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            topicId: topicId,
                        },
                        success: function (response) {
                            if (response) {
                                toastr[response['status']](response['msg']);
                                $('#topicList').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
    </script>



    <script>
        $("#myschool").on('change', function(event){
            event.preventDefault();
            var school_id = $(this).val();
            makeAjaxRequest(school_id);
        });
        function makeAjaxRequest(school_id){
            $.ajax({
                type: "GET",
                data: { school_id: school_id },
                url: "/courses-per-school",
                success: function(res) {
                    $("#courseList").html(res);
                }
            });
        }
    </script>

@endsection

