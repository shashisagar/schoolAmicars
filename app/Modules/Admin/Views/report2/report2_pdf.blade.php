
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
<div class="row" style="margin-left:110 !important; text-align:right;">
    <h dir="rtl">{{trans('message.SchoolName')}}</h>
    <h dir="rtl">{{$name}}</h>
    <br>

    <table>
        <tr>
            <th  dir="rtl">{{trans('message.RuleNo')}}</th>
            <th  dir="rtl">{{trans('message.ScientificRule')}}</th>
            <th  dir="rtl">{{trans('message.CourseName')}}</th>
            <th  dir="rtl">{{trans('message.TeacherName')}}</th>
        </tr>

        <?php $i = 0 ?>

        @foreach ($reportTwoList as $reportList)
            <?php $i++ ?>
            <tr class="demo">
                <td>{{ $i}}</td>
                <td dir="rtl">{{ $reportList->scientific_rule }}</td>
                <td dir="rtl">{{ $reportList->course_name }}</td>
                <td dir="rtl">{{ $reportList->teacher_name }}</td>
            </tr>
        @endforeach
    </table>

</div>

</div>
</body>


