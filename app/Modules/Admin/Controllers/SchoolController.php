<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Redirect;
use View;

/**
 * Class SchoolController
 */
class SchoolController extends Controller
{
    public function manageSchool()
    {
        return view('Admin::school.manageSchool');
    }

    public function addSchool(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'school_name' => 'required',
                'main_image' => 'required|image|mimes:jpeg,bmp,png|max:300',
                'other_image' => 'image|mimes:jpeg,bmp,png|max:300',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["code" => '400', 'message' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $image = $_FILES['main_image'];
                $array = explode('.', $image['name']);
                $extension = end($array);
                $mainImageURL = uploadImageToStoragePath($image['tmp_name'], 'school', 'school-main' . rand() . '-' . time() . '.' . $extension, 700, 500);

                if ($_FILES['other_image']['size'] != 0) {
                    $image = $_FILES['other_image'];
                    $array = explode('.', $image['name']);
                    $extension = end($array);
                    $otherImageURL = uploadImageToStoragePath($image['tmp_name'], 'school', 'school-other' . rand() . '-' . time() . '.' . $extension, 700, 500);
                } else
                    $otherImageURL = NULL;

                $data = array();
                $insertedResponse['code'] = 400;
                if ($mainImageURL) {
                    $data['name'] = $request->input('school_name');
                    $data['image_1'] = $mainImageURL;
                    $data['image_2'] = $otherImageURL;

                    DB::table('schools')->insert($data);
                    $insertedResponse['code'] = 200;
                }

                if ($insertedResponse['code'] == 200) {
                    return Redirect::back()->with(['code' => '200', 'message' => 'New School ' . $request->input('school_name') . ' has been added.']);
                } else {
                    return Redirect::back()->with(['code' => '400', 'message' => 'Something went wrong, please reload the page and try again.']);
                }
            }
        }

        return view('Admin::school.addSchool');
    }

    public function editSchool(Request $request, $schoolId)
    {
        $schoolDetails = (array)DB::table('schools')
            ->where('schools_id', '=', $schoolId)
            ->first();

        if ($request->isMethod('post')) {

            $rules = [
                'school_name' => 'required',
                'main_image' => 'image|mimes:jpeg,bmp,png|max:300',
                'other_image' => 'image|mimes:jpeg,bmp,png|max:300',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["code" => '400', 'message' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $image = $_FILES['main_image'];
                $data = array();
                $data['name'] = $request->input('school_name');
                if ($image['error'] == 0) {
                    $array = explode('.', $image['name']);
                    $extension = end($array);
                    $mainImageURL = uploadImageToStoragePath($image['tmp_name'], 'school', 'school-main' . rand() . '-' . time() . '.' . $extension, 700, 500);
                    if ($mainImageURL) {
                        $data['image_1'] = $mainImageURL;
                        deleteImageFromStoragePath($schoolDetails['image_1']);
                    }
                }

                if ($_FILES['other_image']['size'] != 0) {
                    $image = $_FILES['other_image'];
                    $array = explode('.', $image['name']);
                    $extension = end($array);
                    $otherImageURL = uploadImageToStoragePath($image['tmp_name'], 'school', 'school-other' . rand() . '-' . time() . '.' . $extension, 700, 500);
                    $data['image_2'] = $otherImageURL;

                    if ($schoolDetails['image_2'] != NULL)
                        deleteImageFromStoragePath($schoolDetails['image_2']);
                }

                DB::table('schools')
                    ->where('schools_id', '=', $schoolId)
                    ->update($data);

                return Redirect::back()->with(['code' => '200', 'message' => 'School ' . $request->input('school_name') . ' has been updated.']);
            }
        }

        return view('Admin::school.editSchool', ['schoolDetails' => $schoolDetails]);
    }

    public function schoolAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        if ($method) {
            switch ($method) {
                case 'deleteSchool':
                    $schoolDetails = DB::table('schools')
                        ->where('schools_id', '=', $request->input('schoolId'))
                        ->first();
                    if($schoolDetails->image_1 != NULL)
                        deleteImageFromStoragePath($schoolDetails->image_1);

                    if($schoolDetails->image_2 != NULL)
                        deleteImageFromStoragePath($schoolDetails->image_2);

                    $result = DB::table('schools')
                        ->where('schools_id', '=', $request->input('schoolId'))
                        ->delete();
                    if ($result)
                        echo json_encode(['status' => 'success', 'msg' => 'School detail has been deleted']);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! School detail has not been deleted']);
                    die;
                    break;
                case 'allSchoolList':
                    $schoolList = DB::table('schools')->select('schools_id', 'name', 'image_1');

                    return Datatables::of($schoolList)
                        ->addColumn('image', function ($schoolList) {
                            return '<img src="' . $schoolList->image_1 . '" width="50px">';
                        })
                        ->addColumn('deleteAction', function ($schoolList) {
                            return '<span class="tooltips" title="Delete School Detail." data-placement="top">
                              <a href="javascript:;" data-schoolId="' . $schoolList->schools_id . '" class="btn btn-danger delete-school" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit School Detail." data-placement="top">
                              <a href="/edit-school/' . $schoolList->schools_id . '" class="btn btn-primary" style="margin-left: 10%;">
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