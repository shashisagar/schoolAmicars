@extends('Admin::layouts.master')
@section('title')
    {{trans('message.ManageSchool')}}
@endsection

@section('pageTitle')
    {{trans('message.ManageSchool')}}
@endsection

@section('menuLink')
    <ol class="breadcrumb">
        <li> {{trans('message.School')}}</li>
        <span class="userDefineArrow"></span>
    </ol>
    <ol class="breadcrumb">
        <li> {{trans('message.ViewSchool')}}</li>
    </ol>
@endsection

@section('head')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <style>

        th:nth-child(1), th:nth-child(2), th:nth-child(3), th:nth-child(4){
            text-align: center !important;
        }

        td:nth-child(1), td:nth-child(3), td:nth-child(4) {
            text-align: center !important;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <h2>{{trans('message.SchoolList')}}</h2><br>
                    <table id="schoolList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.SchoolId')}}</th>
                            <th>{{trans('message.SchoolName')}}</th>
                            <th>{{trans('message.SchoolImage')}}</th>
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

    <script src="//cdn.datatables.net/plug-ins/1.10.15/i18n/Hebrew.json"></script>



    <script>
        $(document).ready(function () {
            //for activate the side menu
            $('#school, #viewSchool').addClass('active');
            $('#school').addClass('open');

            //It is ajax function which added a csrf token in meta tag of view page
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#schoolList').DataTable({
                processing: true,
                serverSide: true,
                "scrollX": true,

                "language": {
                    "url": "/lang/pagination/datatables"
                },

                "ajax": {
                    url: "/school-ajax-handler",
                    type: 'POST',
                    data: {
                        method: 'allSchoolList',
                    }
                },

                columns: [
                    {data: 'schools_id', name: 'schools_id'},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image', orderable: false, searchable: false},
                    {data: 'deleteAction', name: 'deleteAction', orderable: false, searchable: false}
                ],

            });

            $(document.body).on('click', '.delete-school', function () {
                var obj = $(this);
                var schoolId = $(this).attr('data-schoolId');
                if (confirm("<?php echo trans('message.DoyouwanttodeletethisSchoolDetails') ?>") == true) {
                    $.ajax({
                        url: '/school-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'deleteSchool',
                            schoolId: schoolId,
                        },
                        success: function (response) {
                            if (response) {
                                toastr[response['status']](response['msg']);
                                $('#schoolList').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection

