<?php

namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Redirect;
use View;

/**
 * Class TeacherController
 */
class ReportOneController extends Controller
{
    public function manageReport()
    {
        if(Auth::user()->role == 1) {
        $schoolList = DB::table('schools')->get();
        return view('Admin::report1.report1', ['schoolList' => $schoolList]);
      }
    else{
        $schools_id=Auth::user()->schools_id;
        $allCourses= DB::table('courses')
            ->where('schools_id',$schools_id)
            ->get();

        return view('Admin::report1.report1', ['allCourses' => $allCourses]);

    }
    }


    public function reportDetails(Request $request)
    {
        $term_courses_id = Input::get('term_courses_id');

       // dd($term_courses_id);

        Session::put('term_courses_id', $term_courses_id);

//        $teacherList = DB::table('courses_relation')
//            ->where('courses_id_a','=',$term_courses_id)
//            ->select('teachers_id_a')
//            ->first();
//
//        $teacherNameA=$teacherList->teachers_id_a;
//
//        $teacherList1 = DB::table('courses_relation')
//            ->where('courses_id_b',$term_courses_id)
//            ->select('teachers_id_b')
//            ->first();
//
//        $teacherNameB=$teacherList1->teachers_id_b;
//     //   dd($teacherNameB);
//
//
//        $teacherName = DB::table('teachers')
//            ->where('teachers_id',$teacherNameA)
//            ->orWhere('teachers_id',$teacherNameB)
//            ->select('teacher_name')
//            ->get();


        DB::statement(DB::raw('set @rownum=0'));

        $topicsList = DB::table('topic')
            ->join('scientific_term_per_topic', 'scientific_term_per_topic.topic_id', '=', 'topic.topic_id')
            ->join('scientific_terms', 'scientific_term_per_topic.scientific_terms_id', '=', 'scientific_terms.scientific_terms_id')
            ->join('scientific_rule', 'scientific_rule.scientific_rule_id', '=', 'scientific_term_per_topic.scientific_rule_id')
            ->where('topic.courses_id',$term_courses_id)
            ->where('scientific_term_per_topic.courses_id',$term_courses_id)
            ->select('topic.topic_name','scientific_terms.scientific_term','scientific_rule.scientific_rule',DB::raw('@rownum  := @rownum  + 1 AS rownum'));

//        echo json_encode($teacherName);
        return Datatables::of($topicsList)
            ->make(true);

    }

    public function reportDownload(Request $request)
    {
        $term_courses_id=Session::get('term_courses_id');

       // dd($term_courses_id);
        $schools_id= DB::table('courses')
            ->where('courses_id',$term_courses_id)
            ->select('schools_id')
            ->first();

      //  dd($schools_id);

        $schoolId= $schools_id->schools_id;

        $schoolName= DB::table('schools')
            ->where('schools_id',$schoolId)
            ->select('name')
            ->first();

        $name=$schoolName->name;

      // dd($name);

       // dd($term_courses_id);
        $topicsList = DB::table('topic')
            ->join('scientific_term_per_topic', 'scientific_term_per_topic.topic_id', '=', 'topic.topic_id')
            ->join('scientific_terms', 'scientific_term_per_topic.scientific_terms_id', '=', 'scientific_terms.scientific_terms_id')
            ->join('scientific_rule', 'scientific_rule.scientific_rule_id', '=', 'scientific_term_per_topic.scientific_rule_id')
            ->where('topic.courses_id',$term_courses_id)
            ->where('scientific_term_per_topic.courses_id',$term_courses_id)
            ->select('topic.topic_name','scientific_terms.scientific_term','scientific_rule.scientific_rule',DB::raw('@rownum  := @rownum  + 1 AS rownum'))
            ->get();






        $teacherList = DB::table('courses_relation')
            ->join('courses as coursesA', 'courses_relation.courses_id_a', '=', 'coursesA.courses_id')
            ->join('courses as coursesB', 'courses_relation.courses_id_b', '=', 'coursesB.courses_id')
            ->join('teachers as teachersA', 'courses_relation.teachers_id_a', '=', 'teachersA.teachers_id')
            ->join('teachers as teachersB', 'courses_relation.teachers_id_b', '=', 'teachersB.teachers_id')

            ->where('courses_relation.courses_id_a',$term_courses_id)

            ->where('courses_relation.schools_id',$schoolId)
            ->select('teachersA.teacher_name')
            ->first();

        $teacherName="";

        if(!empty($teacherList))
        {
        $teacherName=$teacherList->teacher_name;
        // dd($teacherName);
        }
        else {
           // dd("fffffffffffffffffff");
            $teacherList = DB::table('courses_relation')
                ->join('courses as coursesA', 'courses_relation.courses_id_a', '=', 'coursesA.courses_id')
                ->join('courses as coursesB', 'courses_relation.courses_id_b', '=', 'coursesB.courses_id')
                ->join('teachers as teachersA', 'courses_relation.teachers_id_a', '=', 'teachersA.teachers_id')
                ->join('teachers as teachersB', 'courses_relation.teachers_id_b', '=', 'teachersB.teachers_id')

                ->where('courses_relation.courses_id_b',$term_courses_id)

                ->where('courses_relation.schools_id',$schoolId)
                ->select('teachersB.teacher_name')
                ->first();

            $teacherName=$teacherList->teacher_name;
           // dd($teacherName);
        }

      //  dd($teacherName);





//        $pdf = App::make('dompdf.wrapper');
//
//        foreach ($topicsList as $topics) {
//            $pdf->loadHTML('<p>'.$topics->scientific_rule.'</p>');
//
//            return $pdf->stream();
//        }
//        Session::flush();


        $courseName= DB::table('courses')
            ->where('courses_id',$term_courses_id)
            ->select('course_name')
            ->get();

//        $schoolName= DB::table('schools')
//            ->where('schools_id',$term_courses_id)
//            ->select('name')
//            ->get();

        view()->share('topicsList',$topicsList);
        view()->share('courseName',$courseName);
        view()->share('name',$name);
        view()->share('teacherName',$teacherName);


        if($request->has('download')){
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('Admin::report1.report1_pdf');
//            $pdf = PDF::loadView('welcome');
            Session::forget('term_courses_id');
            return $pdf->download('report1_pdf.pdf');
        }
        return view('Admin::report1.report1_pdf');
    }

}//End of Class