@extends('Admin::layouts.master')


@section('title')
    {{trans('message.ManageMainTeacher')}}
@endsection

@section('pageTitle')
    {{trans('message.ManageMainTeacher')}}
@endsection

@section('menuLink')
    <ol class="breadcrumb">
        <li>{{trans('message.MainTeacher')}}</li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li>{{trans('message.ViewMainTeacher')}}</li>
    </ol>
@endsection

@section('head')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <style>

        th:nth-child(1), th:nth-child(2), th:nth-child(3), th:nth-child(4),
        th:nth-child(5), th:nth-child(6), th:nth-child(7), th:nth-child(8){
            text-align: center !important;
        }

        td:nth-child(1), td:nth-child(4), td:nth-child(5),
        td:nth-child(7), td:nth-child(8){
            text-align: center !important;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <h2>{{trans('message.MainTeacherList')}}</h2><br>
                    <table id="teacherList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.Number')}}</th>
                            <th>{{trans('message.Name')}}</th>
                            <th>{{trans('message.Email')}}</th>
                            {{--<th>{{trans('message.SchoolImage')}}</th>--}}
                            {{--<th>{{trans('message.SchoolId')}}</th>--}}
                            <th>{{trans('message.SchoolName')}}</th>
                            <th>{{trans('message.Status')}}</th>
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
            $('#teacher, #viewTeacher').addClass('active');
            $('#teacher').addClass('open');

            //It is ajax function which added a csrf token in meta tag of view page
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#teacherList').DataTable({
                processing: true,
                serverSide: true,
                "scrollX": true,
                "language": {
                    "url": "/lang/pagination/datatables"
                },
                "ajax": {
                    url: "/teacher-ajax-handler",
                    type: 'POST',
                    data: {
                        method: 'allTeacherList',
                    }
                },
                columns: [
                    {data: 'rownum', name: 'rownum'},
                    {data: 'name', name: 'users.name'},
                    {data: 'email', name: 'users.email'},
//                    {data: 'image', name: 'image', orderable: false, searchable: false},
//                    {data: 'schools_id', name: 'users.schools_id'},
                    {data: 'schoolName', name: 'schools.name'},
                    {data: 'status', name: 'users.status', searchable: false},
                    {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                ]
            });

            $(document.body).on('click', '.userStatus', function () {
                var obj = $(this);
                var userId = $(this).attr('data-userId');
                var status = -1;
                if (obj.hasClass('btn-success')) {
                    status = 2;
                } else if (obj.hasClass('btn-danger')) {
                    status = 1;
                }
                if (status == 2 || status == 1) {
                    $.ajax({
                        url: '/teacher-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'changeUserStatus',
                            userId: userId,
                            status: status,
                        },
                        success: function (response) {
                            toastr[response['status']](response['msg']);
                            if (response['status'] == "success") {
                                if (obj.hasClass('btn-success')) {
                                    obj.removeClass('btn-success');
                                    obj.addClass('btn-danger');
                                    obj.text('Inactive');
                                    obj.attr('disabled','true');
                                } else {
                                    obj.removeClass('btn-danger');
                                    obj.addClass('btn-success');
                                    obj.text('Active');
                                    obj.attr('disabled','true');
                                }
                                setTimeout(function() {obj.removeAttr('disabled'); }, 5000);
                            }
                        }
                    });
                }
            });

            $(document.body).on('click', '.delete-teacher', function () {
                var obj = $(this);
                var userId = $(this).attr('data-userId');
                if (confirm("<?php echo trans('message.DoyouwanttodeletethisMainTeacher!') ?>") == true) {
                    $.ajax({
                        url: '/teacher-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'deleteMainTeacher',
                            userId: userId,
                        },
                        success: function (response) {
                            if (response) {
                                toastr[response['status']](response['msg']);
                                $('#teacherList').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection

