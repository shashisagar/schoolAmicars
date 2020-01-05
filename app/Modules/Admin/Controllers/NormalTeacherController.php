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


class NormalTeacherController extends Controller
{
    public function manageTeacher()
    {
        $schoolList = DB::table('schools')->get();
        return view('Admin::normalTeacher.manageNormalTeacher',['schoolList' => $schoolList]);
    }

    public function addNormalTeacher(Request $request)
    {

        if (Auth::user()->role == 1) {
            if ($request->isMethod('post')) {
                $rules = [
                    'normal_teacher_name' => 'required',
                    'school' => 'required',

                ];

                //dd("ffffffffffffffffffff");

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $name = $request->input('normal_teacher_name');
                    $school_id = $request->input('school');

                    DB::table('teachers')->insert(
                        ['teacher_name' => $name, 'schools_id' => $school_id]
                    );


                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NormalTeacher') . $request->input('name') . trans('message.hasbeenadded')]);
                }
            }

            $schoolList = DB::table('schools')
                ->select('schools_id', 'name')
                ->get();

            return view('Admin::normalTeacher.addNormalTeacher', ['schoolList' => $schoolList]);
        }
        else{
            if ($request->isMethod('post')) {
                $rules = [
                    'normal_teacher_name' => 'required',

                ];

                //dd("ffffffffffffffffffff");

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $name = $request->input('normal_teacher_name');

                    $school_id=Auth::user()->schools_id;


//                    $school_id = $request->input('school');

                    DB::table('teachers')->insert(
                        ['teacher_name' => $name, 'schools_id' => $school_id]
                    );


                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NormalTeacher') . $request->input('name') . trans('message.hasbeenadded')]);
                }
            }



            return view('Admin::normalTeacher.addNormalTeacher');
        }


    }


    public function editNormalTeacher(Request $request, $teacherId)
    {
        $teacherDetails = (array)DB::table('teachers')
            ->where('teachers_id', '=', $teacherId)
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


                    $teacherUpdate = DB::table('teachers')
                        ->where('teachers_id', '=', $teacherId)
                        ->update(['teacher_name' => $name]);

                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NormalTeacher') . $request->input('name') .  trans('message.hasbeenUpdated')]);
                }
            }

            return view('Admin::normalTeacher.editNormalTeacher', ['teacherDetails' => $teacherDetails]);
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

                    $teacherUpdate = DB::table('teachers')
                        ->where('teachers_id', '=', $teacherId)
                        ->update(['teacher_name' => $name, 'schools_id' => $schools_id]);

                    return Redirect::back()->with(['code' => '200', 'message' =>  trans('message.NormalTeacher') . $request->input('name') .  trans('message.hasbeenUpdated')]);
                }
            }

            return view('Admin::normalTeacher.editNormalTeacher', ['teacherDetails' => $teacherDetails]);

        }
    }

    public function normalTeacherAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        $schools_id = $request->input('schools_id');
        if ($method) {
            switch ($method) {
                case 'deleteNormalTeacher':
                    $result = DB::table('teachers')
                        ->where('teachers_id', '=', $request->input('datanormalteacherId'))
                        ->delete();
                    if ($result)
                        echo json_encode(['status' => 'success', 'msg' => trans('message.NormalTeacherhasbeendeleted')]);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! Normal Teacher has not been deleted']);
                    die;
                    break;
                case 'allNormalTeacherList':
                    DB::statement(DB::raw('set @rownum=0'));
                    if (Auth::user()->role == 1)
                    $normalTeacherList = DB::table('teachers')
                        ->where('schools_id', '=', $schools_id)
                        ->select('teachers_id', 'teacher_name'
                           ,DB::raw('@rownum  := @rownum  + 1 AS rownum'));
                    else
                        $normalTeacherList = DB::table('teachers')
                            ->join('schools', 'teachers.schools_id', '=', 'schools.schools_id')
                            ->where('teachers.schools_id', '=', Auth::user()->schools_id)
                            ->select('teachers.teachers_id', 'teachers.teacher_name', 'teachers.schools_id',
                                'schools.name as schoolName', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

                    return Datatables::of($normalTeacherList)
                        ->addColumn('deleteAction', function ($normalTeacherList) {
                            if (Auth::user()->role == 1)
                            return '<span class="tooltips" title="Delete Main Courses." data-placement="top">
                              <a href="javascript:;" data-normalteacherId="' . $normalTeacherList->teachers_id . '" class="btn btn-danger delete-normalteacher" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-normalTeacher/' . $normalTeacherList->teachers_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                            else
                               return  '<span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-normalTeacher/' . $normalTeacherList->teachers_id . '" class="btn btn-primary" style="margin-left: 10%;">
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