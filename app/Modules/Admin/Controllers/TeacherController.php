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
 * Class TeacherController
 */
class TeacherController extends Controller
{
    public function manageTeacher()
    {
        return view('Admin::mainTeacher.manageTeacher');
    }

    public function addTeacher(Request $request)
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
                $data['role'] = 2;
                $data['status'] = 2;
                $data['password'] = Hash::make($request->input('password'));
                User::create($data);
                return Redirect::back()->with(['code' => '200', 'message' => trans('message.MainTeacher') . $request->input('name') .  trans('message.hasbeenadded')]);
            }
        }

        $schoolList = DB::table('schools')
            ->select('schools_id', 'name')
            ->get();

        return view('Admin::mainTeacher.addTeacher', ['schoolList' => $schoolList]);
    }

    public function editTeacher(Request $request, $teacherId)
    {

        $teacherDetails = (array)DB::table('users')
            ->where('id', '=', $teacherId)
            ->where('role', '=', 2)
            ->first();

        $schoolList = DB::table('schools')
            ->select('schools_id', 'name')
            ->get();

        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$teacherId,
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

                User::where('id', '=', $teacherId)->update($data);

                return Redirect::back()->with(['code' => '200', 'message' => trans('message.MainTeacher') . $request->input('name') .  trans('message.hasbeenUpdated')]);
            }
        }

        return view('Admin::mainTeacher.editTeacher', ['teacherDetails' => $teacherDetails, 'schoolList' => $schoolList]);
    }

    public function teacherAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        if ($method) {
            switch ($method) {
                case 'deleteMainTeacher':
                    $teacherDetails = DB::table('users')
                        ->where('id', '=', $request->input('userId'))
                        ->first();

                    if ($teacherDetails->profilepic != NULL)
                        deleteImageFromStoragePath($teacherDetails->profilepic);

                    $result = DB::table('users')
                        ->where('id', '=', $request->input('userId'))
                        ->delete();
                    if ($result)
                        echo json_encode(['status' => 'success', 'msg' => trans('message.MainTeacherhasbeendeleted')]);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! Main Teacher has not been deleted']);
                    die;
                    break;
                case 'allTeacherList':

                    DB::statement(DB::raw('set @rownum=0'));


                    $teacherList = DB::table('users')
                        ->join('schools', 'users.schools_id', '=', 'schools.schools_id')
                        ->where('users.role', '=', 2)
                        ->select('users.id', 'users.name', 'users.email', 'users.profilepic',
                            'users.status', 'users.schools_id', 'schools.name as schoolName',DB::raw('@rownum  := @rownum  + 1 AS rownum'));

                    return Datatables::of($teacherList)
                        ->addColumn('image', function ($teacherList) {
                            if ($teacherList->profilepic == NULL || $teacherList->profilepic == '')
                                return '<img src="/image/uploads_userAvatar_avatar.png" width="50px">';
                            else
                                return '<img src="' . $teacherList->profilepic . '" width="50px">';
                        })
                        ->addColumn('status', function ($teacherList) {
                            return '<button class="btn btn-block ' . (($teacherList->status == 1) ? "btn-success" : "btn-danger") . ' userStatus" data-userId="' . $teacherList->id . '">' . (($teacherList->status == 1) ? trans('message.Active') :  trans('message.Inactive')) . ' </button>';
                        })
                        ->addColumn('deleteAction', function ($teacherList) {
                            return '<span class="tooltips" title="Delete Main Teacher." data-placement="top">
                              <a href="javascript:;" data-userId="' . $teacherList->id . '" class="btn btn-danger delete-teacher" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit Main Teacher Detail." data-placement="top">
                              <a href="/edit-teacher/' . $teacherList->id . '" class="btn btn-primary" style="margin-left: 10%;">
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