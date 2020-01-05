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
            <a href="{{ route('reportonepdfview',['download'=>'pdf']) }}">{{trans('message.DownloadPDF')}}</a>
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
                        <div id="options"></div>
                        <div>
                            <div class="col-sm-2"> <label>{{trans('message.CourseName')}}</label></div>
                            <div class="col-sm-3">
                                <select class="js-example-responsive form-control" name="course_name" id="courseList">
                                    <option value="">--{{trans('message.Select')}}--</option>

                                </select>
                                <span class="error">{!! $errors->first('course_name') !!}</span>
                            </div>
                        </div>
                        <br></br><br>
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
                    <br>
                    <table id="reportOneList" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('message.TopicNo')}}</th>
                            <th>{{trans('message.TopicName')}}</th>
                            <th>{{trans('message.ScientificTerm')}}</th>
                            <th>{{trans('message.ScientificRule')}}</th>
                        </tr>


                        </thead>
                    </table>

                        <div id="courseList"></div>


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
            $('#allReport, #reportOnedetails').addClass('active');
            $('#reportOnedetails').addClass('open');

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
                $('#reportOneList').DataTable({
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,
                    "scrollX": true,
                    "language": {
                        "url": "/lang/pagination/datatables"
                    },
                    dom: 'lBfrtip',
                    buttons: [
                        'pdf'
                    ],
                    "ajax": {
                        url: "/report-details",
                        type: 'POST',
                        data: { term_courses_id: term_courses_id },
                    },
                    columns: [
                        {data: 'rownum', name: 'rownum'},
                        {data: 'topic_name', name: 'topic.topic_name'},
                        {data: 'scientific_term', name: 'scientific_terms.scientific_term'},
                        ({data: ('scientific_rule'), name: 'scientific_rule.scientific_rule'}),

                    ],

//                    success: function (response) {
//
//                        alert(response);
////                        var id = response.id;
////                        $('#update_certificationName' + id).html(response.certification_name);
////                        $('#update_certificationYear' + id).html(response.certification_year);
//
//                    },

                })


            }
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

