@extends('Admin::layouts.master')



@section('title')
    {{trans('message.ManageMainCourses')}}
@endsection

@section('pageTitle')
    {{trans('message.ManageMainCourses')}}
@endsection



@section('menuLink')
    <ol class="breadcrumb">
        <li>{{trans('message.MainCourses')}}</li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>{{trans('message.ViewMainCourse')}}</li>
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
                    <h2>{{trans('message.MainCoursesList')}}</h2><br>
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
                    <br>

                    <table id="coursesList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.CourseNo')}}</th>
                            <th>{{trans('message.CourseName')}}</th>

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
            $('#courses, #viewCourses').addClass('active');
            $('#viewCourses').addClass('open');


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
                $('#coursesList').DataTable({
                    processing: true,
                    serverSide: true,
                    "scrollX": true,
                    "bDestroy": true,
                    "language": {
                        "url": "/lang/pagination/datatables"
                    },
                    "ajax": {
                        url: "/course-ajax-handler",
                        type: 'POST',
                        data: {
                            method: 'allCoursesList',
                            schools_id:schools_id
                        }
                    },
                    columns: [
                        {data: 'rownum', name: 'rownum'},
                        {data: 'course_name', name: 'courses.course_name'},
                        {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                    ]
                })
            }

            $('#coursesList').DataTable({
                processing: true,
                serverSide: true,
                "scrollX": true,
 "bDestroy": true,
"language": {
                                        "url": "/lang/pagination/datatables"
                                    },
                "ajax": {
                    url: "/course-ajax-handler",
                    type: 'POST',
                    data: {
                        method: 'allCoursesList',

                    }
                },
                columns: [
                    {data: 'rownum', name: 'rownum'},
                    {data: 'course_name', name: 'courses.course_name'},
                    {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                ]
            })


            $(document.body).on('click', '.delete-course', function () {
                var obj = $(this);
                var courseId = $(this).attr('data-courseId');
                if (confirm("<?php echo trans('message.DoyouwanttodeletethisMainCourse!') ?>") == true) {
                    $.ajax({
                        url: '/course-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'deleteMainCourse',
                            courseId: courseId,
                        },
                        success: function (response) {
                            if (response) {
                                toastr[response['status']](response['msg']);
                                $('#coursesList').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection

