<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use stdClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    /*
       |--------------------------------------------------------------------------
       | Registration & Login Controller
       |--------------------------------------------------------------------------
       |
       | This controller handles the registration of new users, as well as the
       | authentication of existing users. By default, this controller uses
       | a simple trait to add these behaviors. Why don't you explore it?
       |
       */
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * It is showing max number of logIn attempt
     */
    protected $maxLoginAttempts = 5;

    /**
     * It is showing lockout time in seconds,
     * if you want continuous increment in lockout time then set it as zero.
     */
    protected $lockoutTime = 0;

    /**
     * It is showing time after which lockoutTime for continuous increment will be reset.
     */
    protected $autoLockoutTime = 86400; //one day

    /**
     * It is showing time after which max login attempt will be reset.
     */
    protected $loginAttemptTime = 3600; //one hour

    /**
     * This function shows the admin dashboard view page with all
     * calculated detail.
     */
    public function dashboard(Request $request)
    {
//        $objAdmin = Admin::getInstance();
//        $data = $objAdmin->getRecordsForDashboard();
       // return view("Admin::admin.dashboard", ['data' => array()]);

       // dd("ffffffffffffffffffffffffff");

        //dd("gggggggggggggggggggg");


        $schoolList = DB::table('schools')->get();
        $ruleList = DB::table('scientific_rule')->get();


        if ($request->isMethod('post')) {

            $file = $request->file('upload_file');
            $fileType = $request->input('fileType');
            $schoolCourseId = $request->input('schoolCourseId');

            if ($file)
                $fileExtension = strtolower($file->getClientOriginalExtension());
            else
                $fileExtension = '';

            $inputData = [
                'upload_file' => $fileExtension,
            ];

            if ($fileType == 'pdf_a' || $fileType == 'pdf_b')
                $rules = [
                    'upload_file' => 'required|in:pdf,',
                ];
            else if ($fileType == 'msWord_a' || $fileType == 'msWord_b')
                $rules = [
                    'upload_file' => 'required|in:docx,doc,',
                ];

            $validator = Validator::make($inputData, $rules);


            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["status" => 'error', 'msg' => 'Please upload the file according to format.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $fileName = 'school-course-' . $fileType . '-' . $schoolCourseId . '.' . $fileExtension;

//                $file->move(storage_path() . '/uploads/schoolCourseFiles', $fileName);
//                $fileUrl = storage_path() . '/uploads/schoolCourseFiles/' . $fileName;


                $file->move('uploads/schoolCourseFiles', $fileName);
                $fileUrl = 'uploads/schoolCourseFiles/' . $fileName;
                $data = array();

                if ($fileType == 'pdf_a')
                    $data['pdf_file_link_a'] = $fileUrl;
                else if ($fileType == 'pdf_b')
                    $data['pdf_file_link_b'] = $fileUrl;
                else if ($fileType == 'msWord_a')
                    $data['word_file_link_a'] = $fileUrl;
                else if ($fileType == 'msWord_b')
                    $data['word_file_link_b'] = $fileUrl;

                DB::table('courses_relation')
                    ->where('courses_relation_id', '=', $schoolCourseId)
                    ->update($data);
            }
        }

        return view("Admin::schoolCourse.manageSchoolCourse", ['schoolList' => $schoolList,'ruleList'=>$ruleList]);

    }


    /**
     * This function authenticate the admin cred and follow the admin login process.
     */
    public function adminLogin(Request $request)
    {
        //If you want to clear login attempts or auto increase lockoutTime then uncomment to below two lines
//        $this->clearLoginAttempts($request);
//        print_a($this->clearAutoIncreaseLockoutTime($request));

        if ($this->hasTooManyLoginAttempts($request)) {
            return view("Admin::admin.adminLogin")->withErrors([
                'errMsg' => '<strong>Whoops! </strong> Too many login attempts. Please try again in ' . $this->secondsRemainingOnLockout($request) . ' seconds.'
            ]);
        }

        if ($request->isMethod('post')) {

            $email = $request->input('email');
            $password = $request->input('password');

            $this->validate($request,
                [
                    'email' => 'required',
                    'password' => 'required'
                ],
                [
                    'email.required' => 'Please enter email id',
                    'password.required' => 'Please enter a password'
                ]
            );

            if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
                return redirect('/dashboard');
            } else {
                $this->incrementLoginAttempts($request);
                $retriesLeft = $this->retriesLeft($request);
                return redirect('/')->withErrors([
                    'errMsg' => '<strong>Whoops! </strong> Invalid credentials. you have left ' . $retriesLeft . ' attempts only, be careful.'
                ]);
            }
        }
        return view("Admin::admin.adminLogin");
    }

    /**
     * It updates the admin details and image.
     */
    public function adminProfile(Request $request)
    {
        if ($request->isMethod('post')) {

            $rules = array(
                'name' => 'required',
                'profile_image' => 'image|mimes:jpg,png,jpeg,bmp|max:500'
            );

            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return Redirect::back()
                    ->with(['status' => 'error', 'msg' => trans('message.Pleasecorrectthefollowingerrors')])
                    ->withErrors($validation)
                    ->withInput();
            } else {
                $inputData = array(
                    'name' => $request->input('name'),
                );

                $profileImage = $_FILES['profile_image'];
                if ($profileImage['error'] == 0) {
                    $array = explode('.', $profileImage['name']);
                    $extension = end($array);
                    $oldImageURL = Auth::user()->profilepic;
                    if ($oldImageURL != '')
                        deleteImageFromStoragePath($oldImageURL);

                    $imageURL = uploadImageToStoragePath($profileImage['tmp_name'], 'userAvatar', 'users-' . rand() . '-' . time() . '.' . $extension, 1024, 1024);

                    if ($imageURL)
                        $inputData['profilepic'] = $imageURL;
                }

                DB::table('users')
                    ->where('id', '=', Auth::user()->id)
                    ->update($inputData);

                $adminData = DB::table('users')
                    ->where('id', '=', Auth::user()->id)
                    ->select('name', 'email', 'profilepic')
                    ->first();

                return view('Admin::admin.adminProfile', ['adminData' => $adminData, 'status' => 'success', 'msg' => trans('message.Profiledatahasbeenupdatedsuccessfully')]);
            }
        }

        $adminData = DB::table('users')
            ->where('id', '=', Auth::user()->id)
            ->select('name', 'email', 'profilepic')
            ->first();

        if (!$adminData) {
            $adminData = new stdClass();
            $adminData->name = '';
            $adminData->email = '';
            $adminData->profilepic = '';
        }

        return view('Admin::admin.adminProfile', ['adminData' => $adminData]);
    }

    /**
     * This function used for admin logout process.
     */
    public function adminLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * It updates the admin password
     */
    public function UpdatePassword(request $request)
    {
        if ($request->isMethod('post')) {

            $inputData['old_password'] = $request['old_password'];
            $inputData['new_password'] = $request['new_password'];
            $inputData['retype_password'] = $request['retype_password'];

            $rules = [
                'old_password' => 'required',
                'new_password' => 'required|min:8|different:old_password',
                'retype_password' => 'required|same:new_password',
            ];
            $validator = Validator::make($inputData, $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["status" => 'error', 'msg' => trans('message.Pleasecorrectthefollowingerrors')])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if (Auth::validate(['password' => $inputData['old_password']])) {
                    DB::table('users')
                        ->where('id', '=', Auth::user()->id)
                        ->update(['password' => Hash::make($inputData['new_password'])]);

                    return view('Admin::admin.update-password', ["status" => "success", "msg" => trans('message.Passwordhasbeensuccessfullyupdated.')]);
                } else
                    return view('Admin::admin.update-password', ["status" => "error", "msg" => trans('message.Checktheoldpassword.')]);
            }
        }

        return view('Admin::admin.update-password');
    }

    /**
     * Changes the current language and returns to previous page
     */
    public function changeLang(Request $request, $locale = null)
    {
        Session::put('locale', $locale);
        return Redirect::to(URL::previous());
    }


}//End of Class
