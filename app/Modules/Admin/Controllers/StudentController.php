<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Redirect;
use View;

/**
 * Class StudentController
 */
class StudentController extends Controller
{
    public function manageStudent()
    {
        return view('Admin::mainStudent.manageStudent');
    }

    public function addStudent(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'school' => 'required',
                'password' => 'required|min:8',
                'retype_password' => 'required|same:password',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $data = array();
                $data['name'] = $request->input('name');
                $data['email'] = $request->input('email');
                $data['schools_id'] = $request->input('school');
                $data['role'] = 3;
                $data['status'] = 2;
                $data['password'] = Hash::make($request->input('password'));
                User::create($data);
                return Redirect::back()->with(['code' => '200', 'message' => trans('message.MainStudent')  . $request->input('name') .  trans('message.hasbeenadded')]);
            }
        }

        $schoolList = DB::table('schools')
            ->select('schools_id', 'name')
            ->get();

        return view('Admin::mainStudent.addStudent', ['schoolList' => $schoolList]);
    }

    public function editStudent(Request $request, $studentId)
    {

        $studentDetails = (array)DB::table('users')
            ->where('id', '=', $studentId)
            ->where('role', '=', 3)
            ->first();

        $schoolList = DB::table('schools')
            ->select('schools_id', 'name')
            ->get();

        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$studentId,
                'school' => 'required',
                'password' => 'required|min:8',
                'retype_password' => 'required|same:password',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $data = array();
                $data['name'] = $request->input('name');
                $data['email'] = $request->input('email');
                $data['schools_id'] = $request->input('school');
                $data['password'] = Hash::make($request->input('password'));

                User::where('id', '=', $studentId)->update($data);

                return Redirect::back()->with(['code' => '200', 'message' => trans('message.MainStudent')   . $request->input('name') . trans('message.Updated')]);
            }
        }

        return view('Admin::mainStudent.editStudent', ['studentDetails' => $studentDetails, 'schoolList' => $schoolList]);
    }

    public function studentAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        if ($method) {
            switch ($method) {
                case 'deleteMainStudent':
                    $studentDetails = DB::table('users')
                        ->where('id', '=', $request->input('userId'))
                        ->first();

                    if ($studentDetails->profilepic != NULL)
                        deleteImageFromStoragePath($studentDetails->profilepic);

                    $result = DB::table('users')
                        ->where('id', '=', $request->input('userId'))
                        ->delete();
                    if ($result)
                        echo json_encode(['status' => 'success', 'msg' =>trans('message.MainStudenthasbeendeleted')]);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! Main Student has not been deleted']);
                    die;
                    break;
                case 'allStudentList':
                    DB::statement(DB::raw('set @rownum=0'));
                    $studentList = DB::table('users')
                        ->join('schools', 'users.schools_id', '=', 'schools.schools_id')
                        ->where('users.role', '=', 3)
                        ->select('users.id', 'users.name', 'users.email', 'users.profilepic',
                            'users.status', 'users.schools_id', 'schools.name as schoolName',DB::raw('@rownum  := @rownum  + 1 AS rownum'));

                    return Datatables::of($studentList)
                        ->addColumn('image', function ($studentList) {
                            if ($studentList->profilepic == NULL || $studentList->profilepic == '')
                                return '<img src="/image/uploads_userAvatar_avatar.png" width="50px">';
                            else
                                return '<img src="' . $studentList->profilepic . '" width="50px">';
                        })
                        ->addColumn('status', function ($studentList) {
                            return '<button class="btn btn-block ' . (($studentList->status == 1) ? "btn-success" : "btn-danger") . ' userStatus" data-userId="' . $studentList->id . '">' . (($studentList->status == 1) ? trans('message.Active') :  trans('message.Inactive')) . ' </button>';
                        })
                        ->addColumn('deleteAction', function ($studentList) {
                            return '<span class="tooltips" title="Delete Main Student." data-placement="top">
                              <a href="javascript:;" data-userId="' . $studentList->id . '" class="btn btn-danger delete-student" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit Main Student Detail." data-placement="top">
                              <a href="/edit-student/' . $studentList->id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                        })
                        ->make(true);
                    break;
                case 'changeUserStatus':
                    DB::table('users')
                        ->where('id', '=', $request->input('userId'))
                        ->update(['status' => $request->input('status')]);
                    echo json_encode(['status' => 'success', 'msg' =>trans('message.Statushasbeenchanged')]);
                    die;
                    break;
                default:
                    break;
            }
        }
    }

}//End of Class