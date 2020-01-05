@extends('Admin::layouts.master')


@section('title')
    {{trans('message.ManageNormalTeacher')}}
@endsection

@section('pageTitle')
    {{trans('message.ManageNormalTeacher')}}
@endsection

@section('menuLink')
    <ol class="breadcrumb">
        <li>{{trans('message.MainNormalTeacher')}}</li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>{{trans('message.ViewNormalTeacher')}}</li>
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
                    <h2>{{trans('message.NormalTeacherList')}}</h2><br>

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
                    <br><br>
                    <br>
                    @endif
                    <table id="normalTeacherList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.NormalTeacherNumber')}}</th>
                            <th>{{trans('message.NormalTeacher')}}</th>
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
            $('#normalteacher, #viewNormalTeacher').addClass('active');
            $('#viewNormalTeacher').addClass('open');

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
                $('#normalTeacherList').DataTable({
                    processing: true,
                    serverSide: true,
                    "scrollX": true,
                    "bDestroy": true,
                    "language": {
                        "url": "/lang/pagination/datatables"
                    },
                    "ajax": {
                        url: "/normalTeacher-ajax-handler",
                        type: 'POST',
                        data: {
                            method: 'allNormalTeacherList',
                            schools_id:schools_id,
                        }
                    },
                    columns: [
                        {data: 'rownum', name: 'rownum'},
                        {data: 'teacher_name', name: 'teacher_name'},
                        {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                    ]
                })
            }

            $('#normalTeacherList').DataTable({
                processing: true,
                serverSide: true,
                "scrollX": true,
                "bDestroy": true,
                "language": {
                    "url": "/lang/pagination/datatables"
                },
                "ajax": {
                    url: "/normalTeacher-ajax-handler",
                    type: 'POST',
                    data: {
                        method: 'allNormalTeacherList',
                    }
                },
                columns: [
                    {data: 'rownum', name: 'rownum'},
                    {data: 'teacher_name', name: 'teacher_name'},
                    {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                ]
            })
            $(document.body).on('click', '.delete-normalteacher', function () {
                var obj = $(this);
                var datanormalteacherId = $(this).attr('data-normalteacherId');
                if (confirm("<?php echo trans('message.DoyouwanttodeletethisNormalTeacher!') ?>") == true) {
                    $.ajax({
                        url: '/normalTeacher-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'deleteNormalTeacher',
                            datanormalteacherId: datanormalteacherId,
                        },
                        success: function (response) {
                            if (response) {
                                toastr[response['status']](response['msg']);
                                $('#normalTeacherList').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection

