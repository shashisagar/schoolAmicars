<?php

namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\User;
use Illuminate\Http\Request;
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
class ReportTwoController extends Controller
{
    public function manageReport()
    {
        $schoolList = DB::table('schools')->get();
        return view('Admin::report2.report2', ['schoolList' => $schoolList]);
    }


    public function reportDetails(Request $request)
    {
      //  dd("ffffffffffffffffff");
        if (Auth::user()->role == 1) {
            $schools_id = Input::get('schools_id');

            Session::put('schools_id', $schools_id);

            DB::statement(DB::raw('set @rownum=0'));

            $reportTwoList = DB::table('coursesteacher')
                ->leftJoin('teachers', 'teachers.teachers_id', '=', 'coursesteacher.teachers_id')
                ->leftJoin('courses', 'courses.courses_id', '=', 'coursesteacher.courses_id')
                ->leftJoin('scientific_term_per_topic', 'scientific_term_per_topic.courses_id', '=', 'coursesteacher.courses_id')
                ->leftJoin('scientific_rule', 'scientific_rule.scientific_rule_id', '=', 'scientific_term_per_topic.scientific_rule_id')
                ->where('coursesteacher.schools_id', $schools_id)
                ->where('scientific_term_per_topic.schools_id', $schools_id)
                ->where('courses.schools_id', $schools_id)
                ->select('scientific_rule.scientific_rule', 'courses.course_name', 'teachers.teacher_name', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

//        DB::statement(DB::raw('set @rownum=0'));
//
//        $reportTwoList= DB::table('courses_relation')
//            ->join('courses as coursesA', 'courses_relation.courses_id_a', '=', 'coursesA.courses_id')
//            ->join('courses as coursesB', 'courses_relation.courses_id_b', '=', 'coursesB.courses_id')
//            ->join('teachers as teachersA', 'courses_relation.teachers_id_a', '=', 'teachersA.teachers_id')
//            ->join('teachers as teachersB', 'courses_relation.teachers_id_b', '=', 'teachersB.teachers_id')
//            ->join('scientific_rule', 'scientific_rule.schools_id', '=', 'courses_relation.schools_id')
//            ->join('topic', 'topic.topic_id', '=', 'scientific_rule.topic_id')
//            ->join('courses', 'courses.courses_id', '=', 'topic.courses_id')
//
//            ->where('courses_relation.courses_id_a',1)
//            ->where('courses_relation.schools_id',$schools_id)


//            ->where('courses_relation.courses_id_a','coursesA.courses_id')
//            ->select('teachersB.teacher_name')
//            ->get();
//
////        print_r($reportTwoList);
////        die;
//
//            ->select('scientific_rule.scientific_rule','courses.course_name','teachersB.teacher_name',DB::raw('@rownum  := @rownum  + 1 AS rownum'));


//        $reportTwoList = DB::table('scientific_rule')
//            ->join('topic', 'topic.topic_id', '=', 'scientific_rule.topic_id')
//            ->join('courses', 'courses.courses_id', '=', 'topic.courses_id')

//            ->join('courses_relation', 'courses_relation.schools_id', '=', 'courses.schools_id')
//            ->join('teachers', 'teachers.schools_id', '=', 'courses_relation.schools_id')

//
//
//            ->where('courses_relation.teachers_id_a','teachers.teachers_id')
//            ->orWhere('courses_relation.teachers_id_b','teachers.teachers_id')

//            ->where('courses.schools_id',$schools_id)

//            ->where('teachers.schools_id',$schools_id)
//            ->where('courses_relation.schools_id',$schools_id)
//            ->where('courses_relation.courses_id_a','courses.courses_id')
//            ->orWhere('courses_relation.courses_id_b','courses.courses_id')
//            ->where('courses.schools_id',$schools_id)

//            ->select('scientific_rule.scientific_rule','courses.course_name','teachersA.teacher_name',DB::raw('@rownum  := @rownum  + 1 AS rownum'));


//        echo json_encode($teacherName);
        }
        else
        {
            $schools_id = Auth::user()->schools_id;

            Session::put('schools_id', $schools_id);

            DB::statement(DB::raw('set @rownum=0'));



            $reportTwoList = DB::table('coursesteacher')
                ->leftJoin('teachers', 'teachers.teachers_id', '=', 'coursesteacher.teachers_id')
                ->leftJoin('courses', 'courses.courses_id', '=', 'coursesteacher.courses_id')
                ->leftJoin('scientific_term_per_topic', 'scientific_term_per_topic.courses_id', '=', 'coursesteacher.courses_id')
                ->leftJoin('scientific_rule', 'scientific_rule.scientific_rule_id', '=', 'scientific_term_per_topic.scientific_rule_id')
                ->where('coursesteacher.schools_id', $schools_id)
                ->where('scientific_term_per_topic.schools_id', $schools_id)
                ->where('courses.schools_id', $schools_id)
                ->select('scientific_rule.scientific_rule', 'courses.course_name', 'teachers.teacher_name', DB::raw('@rownum  := @rownum  + 1 AS rownum'));


//            $reportTwoList = DB::table('coursesteacher')
//                ->join('teachers', 'teachers.teachers_id', '=', 'coursesteacher.teachers_id')
//                ->join('courses', 'courses.courses_id', '=', 'coursesteacher.courses_id')
//                ->join('scientific_rule', 'scientific_rule.courses_id', '=', 'courses.courses_id')
//                ->where('coursesteacher.schools_id', $schools_id)
//                ->where('scientific_rule.schools_id', $schools_id)
//                ->where('courses.schools_id', $schools_id)
//                ->select('scientific_rule.scientific_rule', 'courses.course_name', 'teachers.teacher_name', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        }

        return Datatables::of($reportTwoList)
             ->make(true);

    }

    public function reportDownload(Request $request)
    {
        $schools_id=Session::get('schools_id');

        $schoolName= DB::table('schools')
            ->where('schools_id',$schools_id)
            ->select('name')
            ->first();

        $name=$schoolName->name;

      //  dd($name);

        $reportTwoList = DB::table('coursesteacher')
            ->join('teachers', 'teachers.teachers_id', '=', 'coursesteacher.teachers_id')
            ->join('courses', 'courses.courses_id', '=', 'coursesteacher.courses_id')
            ->join('scientific_term_per_topic', 'scientific_term_per_topic.courses_id', '=', 'coursesteacher.courses_id')
            ->join('scientific_rule', 'scientific_rule.scientific_rule_id', '=', 'scientific_term_per_topic.scientific_rule_id')
            ->where('coursesteacher.schools_id', $schools_id)
            ->where('scientific_term_per_topic.schools_id', $schools_id)
            ->where('courses.schools_id', $schools_id)
            ->select('scientific_rule.scientific_rule', 'courses.course_name', 'teachers.teacher_name', DB::raw('@rownum  := @rownum  + 1 AS rownum'))->get();



        view()->share('reportTwoList',$reportTwoList);
        view()->share('name',$name);


        if($request->has('download')){
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('Admin::report2.report2_pdf');
//            $pdf = PDF::loadView('welcome');
            Session::forget('schools_id');
            return $pdf->download('report2_pdf.pdf');
        }
        return view('Admin::report2.report2_pdf');
    }

}//End of Class