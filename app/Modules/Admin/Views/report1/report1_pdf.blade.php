<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: "DejaVu Sans";
            font-style: normal;
         
           
        }

       body
{
   font-family: firefly, DejaVu Sans, sans-serif;
  
}
td {
  padding: 0px 0 0 20px;
}


    </style>


</head>

<body>
<div class="row" style="margin-left:20 !important; text-align:right;">


    <h dir="rtl">{{trans('message.SchoolName')}}</h>
     <h dir="rtl">{{$name}}</h>

    <br>
<p>
    <h dir="rtl">{{trans('message.CourseName')}}</h>
    @foreach ($courseName as $courseName)
       <h dir="rtl">{{$courseName->course_name}}</h>
    @endforeach

    <h dir="rtl">{{trans('message.TeacherBy')}}</h>
    {{--@foreach ($teacherName as $teacherName)--}}
        {{--<b>({{$teacherName->teacher_name}})</b>--}}
    {{--@endforeach--}}
    <h dir="rtl">{{$teacherName}}</h>

</p>

    <table >
    <tr>
        <th dir="rtl" style="width:25%">{{trans('message.TopicNo')}}</th>
        <th dir="rtl" style="width:25%">{{trans('message.TopicName')}}</th>
        <th dir="rtl" style="width:25%">{{trans('message.ScientificTerm')}}</th>
        <th dir="rtl" style="width:25%">{{trans('message.ScientificRule')}}</th>
    </tr>

        <?php $i = 0 ?>
    @foreach ($topicsList as $topics)
            <?php $i++ ?>
        <tr dir="rtl">

            <td dir="rtl">{{ $i}}</td>
            <td dir="rtl">{{ $topics->topic_name }}</td>
            <td dir="rtl">{{ $topics->scientific_term }}</td>
            <td dir="rtl">{{ $topics->scientific_rule }}</td>
        </tr>
    @endforeach
</table>

</div>

</body>