@extends('Admin::layouts.master')
@section('title')
    {{trans('message.ManageReport')}}
@endsection

@section('pageTitle')
    {{trans('message.ManageReport')}}
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

    <div class="columns download">
        <p>
            <a href="{{ route('reporttwopdfview',['download'=>'pdf']) }}">{{trans('message.DownloadPDF')}}</a>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <h2>{{trans('message.Report')}}</h2><br>
                    @if(Auth::user()->role == 1)
                    <div>
                    <div class="col-sm-2"> <label>{{trans('message.SchoolName')}}</label></div>
                    <div class="col-sm-3">
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
                    </div>
                    <br></br><br>

                    @endif
                    <table id="reportTwoList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.RuleNo')}}</th>
                            <th>{{trans('message.ScientificRule')}}</th>
                            <th>{{trans('message.CourseName')}}</th>
                            <th>{{trans('message.TeacherName')}}</th>
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
    {{--<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>--}}


    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css"/>--}}
    <script>
        $(document).ready(function () {
            //for activate the side menu
            $('#allReport, #reportTwodetails').addClass('active');
            $('#reportTwodetails').addClass('open');

            //It is ajax function which added a csrf token in meta tag of view page
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#myschool").on('change', function(event){
                event.preventDefault();
                var schools_id = $(this).val();
               // alert(schools_id);

                findReportTwo(schools_id);
            });
            function findReportTwo(schools_id){
                $('#reportTwoList').DataTable({
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,
                    "scrollX": true,
                    "language": {
                        "url": "/lang/pagination/datatables"
                    },
//                    dom: 'lBfrtip',
//                    buttons: [
//                        'pdf'
//                    ],
                    "ajax": {
                        url: "/report-two-details",
                        type: 'POST',
                        data: { schools_id: schools_id },
                    },
                    columns: [
                        {data: 'rownum', name: 'rownum'},
                        {data: 'scientific_rule', name: 'scientific_rule.scientific_rule'},
                        {data: 'course_name', name: 'courses.course_name'},
                        ({data: ('teacher_name'), name: 'teachers.teacher_name'}),

                    ],

                })


            }
            $('#reportTwoList').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
 "language": {
                        "url": "/lang/pagination/datatables"
                    },
                "scrollX": true,
//                    dom: 'lBfrtip',
//                    buttons: [
//                        'pdf'
//                    ],
                "ajax": {
                    url: "/report-two-details",
                    type: 'POST',
                },
                columns: [
                    {data: 'rownum', name: 'rownum'},
                    {data: 'scientific_rule', name: 'scientific_rule.scientific_rule'},
                    {data: 'course_name', name: 'courses.course_name'},
                    ({data: ('teacher_name'), name: 'teachers.teacher_name'}),

                ],

            })

        });
    </script>



    {{--<script>--}}
        {{--$("#myschool").on('change', function(event){--}}
            {{--event.preventDefault();--}}
            {{--var school_id = $(this).val();--}}
            {{--makeAjaxRequest(school_id);--}}
        {{--});--}}
        {{--function makeAjaxRequest(school_id){--}}
            {{--$.ajax({--}}
                {{--type: "GET",--}}
                {{--data: { school_id: school_id },--}}
                {{--url: "/courses-per-school",--}}
                {{--success: function(res) {--}}
                    {{--$("#courseList").html(res);--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}
    {{--</script>--}}

@endsection

