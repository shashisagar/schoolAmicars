<?php

namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Redirect;
use View;

/**
 * Class TeacherController
 */
class CourseController extends Controller
{
    public function manageCourses()
    {
        $schoolList = DB::table('schools')->get();

        return view('Admin::mainCourses.manageCourse',['schoolList' => $schoolList]);
    }

    public function addCourses(Request $request)
    {
        if (Auth::user()->role == 1) {
            if ($request->isMethod('post')) {
                $rules = [
                    'school' => 'required',
                    'course_name' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $school = $request->input('school');
                    $course_name = $request->input('course_name');

                    DB::table('courses')->insert(
                        ['schools_id' => $school, 'course_name' => $course_name]
                    );

                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NewCourses') . $request->input('course_name') . trans('message.hasbeenadded')]);
                }
            }

            $schoolList = DB::table('schools')
                ->select('schools_id', 'name')
                ->get();

            return view('Admin::mainCourses.addCourse', ['schoolList' => $schoolList]);
        }
        else{

            if ($request->isMethod('post')) {
                $rules = [
                    'course_name' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    $school=Auth::user()->schools_id;
                    $course_name = $request->input('course_name');


                    DB::table('courses')->insert(
                        ['schools_id' => $school, 'course_name' => $course_name]
                    );

                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NewCourses') . $request->input('course_name') . trans('message.hasbeenadded')]);
                }
            }


            return view('Admin::mainCourses.addCourse');

        }
    }


    public function editCourse(Request $request, $courseId)
    {
        $courseDetails = (array)DB::table('courses')
            ->where('courses_id', '=', $courseId)
            ->first();

        if (Auth::user()->role == 1) {

            $schoolList = DB::table('schools')
                ->select('schools_id', 'name')
                ->get();

            if ($request->isMethod('post')) {
                $rules = [
                    'name' => 'required',

                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {


                    $name = $request->input('name');
                   // $schools_id = $request->input('school');

                    $courseUpdate = DB::table('courses')
                        ->where('courses_id', '=', $courseId)
                        ->update(['course_name' => $name]);


                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NewCourses') . $request->input('name') . trans('message.hasbeenUpdated')]);
                }
            }

            return view('Admin::mainCourses.editCourse', ['courseDetails' => $courseDetails]);
        }
        else
        {

            if ($request->isMethod('post')) {
                $rules = [
                    'name' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $name = $request->input('name');
                    $schools_id = Auth::user()->schools_id;

                    $courseUpdate = DB::table('courses')
                        ->where('courses_id', '=', $courseId)
                        ->update(['course_name' => $name, 'schools_id' => $schools_id]);


                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NewCourses') . $request->input('name') . trans('message.hasbeenUpdated')]);
                }
            }

            return view('Admin::mainCourses.editCourse', ['courseDetails' => $courseDetails]);

        }
    }

    public function courseAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        $schools_id = $request->input('schools_id');
        if ($method) {
            switch ($method) {
                case 'deleteMainCourse':
                    $result = DB::table('courses')
                        ->where('courses_id', '=', $request->input('courseId'))
                        ->delete();
                    if ($result)
                        echo json_encode(['status' => 'success', 'msg' =>  trans('message.MainCourseshasbeendeleted')]);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! Main Course has not been deleted']);
                    die;
                    break;
                case 'allCoursesList':
                    DB::statement(DB::raw('set @rownum=0'));
                    if (Auth::user()->role == 1)
                    $courseList = DB::table('courses')
                        ->join('schools', 'courses.schools_id', '=', 'schools.schools_id')
                        ->where('courses.schools_id', '=', $schools_id)
                        ->select('courses.courses_id', 'courses.course_name', 'courses.schools_id',
                           'schools.name as schoolName',DB::raw('@rownum  := @rownum  + 1 AS rownum'));
                    else

                        $courseList = DB::table('courses')
                            ->join('schools', 'courses.schools_id', '=', 'schools.schools_id')
                            ->where('courses.schools_id', '=', Auth::user()->schools_id)
                            ->select('courses.courses_id', 'courses.course_name', 'courses.schools_id',
                                'schools.name as schoolName',DB::raw('@rownum  := @rownum  + 1 AS rownum'));


                    return Datatables::of($courseList)
                        ->addColumn('deleteAction', function ($courseList) {
                            if (Auth::user()->role == 1)
                            return '<span class="tooltips" title="Delete Main Courses." data-placement="top">
                              <a href="javascript:;" data-courseId="' . $courseList->courses_id . '" class="btn btn-danger delete-course" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-course/' . $courseList->courses_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                            else
                               return '<span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-course/' . $courseList->courses_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';

                        })
                        ->make(true);
                    break;
                default:
                    break;
            }
        }
    }

}//End of Class