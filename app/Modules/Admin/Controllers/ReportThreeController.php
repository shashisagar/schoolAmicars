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
class ReportThreeController extends Controller
{
    public function manageReport()
    {
        $schoolList = DB::table('schools')->get();
        return view('Admin::report3.report3', ['schoolList' => $schoolList]);
    }


    public function reportDetails(Request $request)
    {
        if (Auth::user()->role == 1) {
            $schools_id = Input::get('schools_id');

            Session::put('schools_id', $schools_id);

            DB::statement(DB::raw('set @rownum=0'));

            $reportThreeList = DB::table('coursesteacher')
                ->join('teachers', 'teachers.teachers_id', '=', 'coursesteacher.teachers_id')
                ->join('courses', 'courses.courses_id', '=', 'coursesteacher.courses_id')
                ->join('scientific_term_per_topic', 'scientific_term_per_topic.courses_id', '=', 'courses.courses_id')

                ->join('scientific_terms', 'scientific_term_per_topic.scientific_terms_id', '=', 'scientific_terms.scientific_terms_id')
                ->where('coursesteacher.schools_id', $schools_id)
                ->where('scientific_term_per_topic.schools_id', $schools_id)
                ->where('courses.schools_id', $schools_id)
                ->select('scientific_terms.scientific_term', 'courses.course_name', 'teachers.teacher_name', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        }
        else{
            $schools_id = Auth::user()->schools_id;

            Session::put('schools_id', $schools_id);

            DB::statement(DB::raw('set @rownum=0'));

            $reportThreeList = DB::table('coursesteacher')
                ->join('teachers', 'teachers.teachers_id', '=', 'coursesteacher.teachers_id')
                ->join('courses', 'courses.courses_id', '=', 'coursesteacher.courses_id')
                ->join('scientific_term_per_topic', 'scientific_term_per_topic.courses_id', '=', 'courses.courses_id')
                ->join('scientific_terms', 'scientific_term_per_topic.scientific_terms_id', '=', 'scientific_terms.scientific_terms_id')
                ->where('coursesteacher.schools_id', $schools_id)
                ->where('scientific_term_per_topic.schools_id', $schools_id)
                ->where('courses.schools_id', $schools_id)
                ->select('scientific_terms.scientific_term', 'courses.course_name', 'teachers.teacher_name', DB::raw('@rownum  := @rownum  + 1 AS rownum'));
        }

        return Datatables::of($reportThreeList)
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

        $reportThreeList=DB::table('coursesteacher')

            ->join('teachers', 'teachers.teachers_id', '=', 'coursesteacher.teachers_id')
            ->join('courses', 'courses.courses_id', '=', 'coursesteacher.courses_id')

            ->join('scientific_term_per_topic', 'scientific_term_per_topic.courses_id', '=', 'courses.courses_id')

            ->join('scientific_terms', 'scientific_term_per_topic.scientific_terms_id', '=', 'scientific_terms.scientific_terms_id')

            ->where('coursesteacher.schools_id',$schools_id)
            ->where('scientific_term_per_topic.schools_id',$schools_id)
            ->where('courses.schools_id',$schools_id)
            ->select('scientific_terms.scientific_term','courses.course_name','teachers.teacher_name',DB::raw('@rownum  := @rownum  + 1 AS rownum'))
           ->get();


        view()->share('reportThreeList',$reportThreeList);
        view()->share('name',$name);


        if($request->has('download')){
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('Admin::report3.report3_pdf');
//            $pdf = PDF::loadView('welcome');
            Session::forget('schools_id');
            return $pdf->download('report3_pdf.pdf');
        }
        return view('Admin::report3.report3_pdf');
    }


}//End of Class