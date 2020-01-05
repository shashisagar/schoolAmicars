<?php

namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Redirect;
use View;

/**
 * Class TeacherController
 */
class TopicController extends Controller
{
    public function manageCourseTopics()
    {
        if (Auth::user()->role == 1) {
            $schoolList = DB::table('schools')->get();

            return view('Admin::mainTopics.manageTopics', ['schoolList' => $schoolList]);
        }
        else
        {
            $schools_id=Auth::user()->schools_id;
            $allCourses = DB::table('courses')
                ->where('schools_id',$schools_id)
                ->get();
            return view('Admin::mainTopics.manageTopics', ['allCourses' => $allCourses]);

        }
    }

    public function addCourseTopic(Request $request)
    {
        if(Auth::user()->role == 1) {
            if ($request->isMethod('post')) {
                $rules = [
                    'school' => 'required',
//                    'teaching_stage' => 'required',
                    'course_name' => 'required',
                    'topic_name' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $school = $request->input('school');
//                    $teaching_stage = $request->input('teaching_stage');
                    $course_name = $request->input('course_name');
                    $topic_name = $request->input('topic_name');

//                print_r($topic_name);
//                die;

                    DB::table('topic')->insert(
                        ['topic_name' => $topic_name, 'schools_id' => $school,  'courses_id' => $course_name]
                    );

                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NewTopic') . $request->input('topic_name') . trans('message.hasbeenadded')]);
                }
            }

            $schoolList = DB::table('schools')
                ->select('schools_id', 'name')
                ->get();

//            $teaching_stage = DB::table('teaching_stage')
//                ->select('teaching_stage_id', 'name')
//                ->get();


//            $allCourses = DB::table('courses')
//                ->where('schools_id',$school_id)
//                ->select('courses_id', 'course_name')
//                ->get();

//        print_r($allCourses);
//        die;

            return view('Admin::mainTopics.addTopic', ['schoolList' => $schoolList]);
        }
        else{

            $school = Auth::user()->schools_id;



            if ($request->isMethod('post')) {
                $rules = [
//                    'teaching_stage' => 'required',
                    'course_name' => 'required',
                    'topic_name' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {

//                    $teaching_stage = $request->input('teaching_stage');
                    $course_name = $request->input('course_name');
                    $topic_name = $request->input('topic_name');

//                print_r($topic_name);
//                die;

                    DB::table('topic')->insert(
                        ['topic_name' => $topic_name, 'schools_id' => $school, 'courses_id' => $course_name]
                    );

                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NewTopic') . $request->input('topic_name') . trans('message.hasbeenadded')]);
                }
            }
//            $school = Auth::user()->schools_id;


//            $teaching_stage = DB::table('teaching_stage')
//                ->select('teaching_stage_id', 'name')
//                ->get();


            $allCourses = DB::table('courses')
                ->where('schools_id',$school)
                ->select('courses_id', 'course_name')
                ->get();


//            print_r($allCourses);
//            die;


            return view('Admin::mainTopics.addTopic', ['allCourses' => $allCourses]);

        }

    }


    public function editTopic(Request $request, $topicId)
    {
       // dd($topicId);
        $topicDetails = DB::table('topic')
            ->where('topic_id', '=', $topicId)
            ->first();

          $topicName = $topicDetails->topic_name;


        if (Auth::user()->role == 1) {

            if ($request->isMethod('post')) {
                $rules = [
                    'course_topic_name' => 'required',

                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    $course_topic_name = $request->input('course_topic_name');


                    $topicUpdate = DB::table('topic')
                        ->where('topic_id', '=', $topicId)
                        ->update(['topic_name' => $course_topic_name]);

                    return Redirect::back()->with(['code' => '200', 'message' =>  trans('message.NewTopic') . $request->input('name') .  trans('message.hasbeenUpdated')]);
                }
            }

            return view('Admin::mainTopics.editTopic', ['topicName' => $topicName]);
        }
        else
        {

            if ($request->isMethod('post')) {
                $rules = [
                    'course_topic_name' => 'required'
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $course_topic_name = $request->input('course_topic_name');

                    $schools_id = Auth::user()->schools_id;

                    $topicUpdate = DB::table('topic')
                        ->where('topic_id', '=', $topicId)
                        ->update(['topic_name' => $course_topic_name]);


                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NewTopic') . $request->input('name') . trans('message.hasbeenUpdated')]);
                }
            }

            return view('Admin::mainTopics.editTopic', ['topicName' => $topicName]);

        }
    }

    public function topicAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        if ($method) {
            switch ($method) {
                case 'deleteMainCourse':
                    $result = DB::table('courses')
                        ->where('courses_id', '=', $request->input('courseId'))
                        ->delete();
                    if ($result)
                        echo json_encode(['status' => 'success', 'msg' => trans('message.MainTopichasbeendeleted')]);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! Main Course has not been deleted']);
                    die;
                    break;
                case 'allTopicsList':
                    DB::statement(DB::raw('set @rownum=0'));

                    if (Auth::user()->role == 1)
                    $topicsList = DB::table('topic')
                        ->join('schools', 'schools.schools_id', '=', 'topic.schools_id')
                        ->join('courses', 'courses.courses_id', '=', 'topic.courses_id')
                        ->join('teaching_stage','teaching_stage.teaching_stage_id', '=', 'topic.teaching_stage_id')
                        ->select('topic.topic_id', 'topic.topic_name','courses.course_name','schools.name as schoolName',
                           'teaching_stage.name', DB::raw('@rownum  := @rownum  + 1 AS rownum'));
                    else
                    $topicsList = DB::table('topic')
                        ->join('schools', 'topic.schools_id', '=', 'schools.schools_id')
                        ->join('courses', 'topic.courses_id', '=', 'courses.courses_id')
                        ->join('teaching_stage', 'topic.schools_id', '=', 'teaching_stage.schools_id')
                        ->where('topic.schools_id', '=', Auth::user()->schools_id)

                        ->select('topic.topic_id', 'topic.topic_name','courses.course_name','schools.name as schoolName',
                            'teaching_stage.name', DB::raw('@rownum  := @rownum  + 1 AS rownum'));


                    return Datatables::of($topicsList)
                        ->addColumn('deleteAction', function ($topicsList) {
                            if (Auth::user()->role == 1)
                            return '<span class="tooltips" title="Delete Main Courses." data-placement="top">
                              <a href="javascript:;" data-courseId="' . $topicsList->topic_id . '" class="btn btn-danger delete-course" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-course-topic/' . $topicsList->topic_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                            else
                               return '<span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-course-topic/' . $topicsList->topic_id . '" class="btn btn-primary" style="margin-left: 10%;">
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


    public function topicDetails(Request $request)
    {
        $term_courses_id = Input::get('term_courses_id');
        DB::statement(DB::raw('set @rownum=0'));

        $topicsList = DB::table('topic')
            ->where('courses_id',$term_courses_id)
            ->select('topic_id','topic_name',DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return Datatables::of($topicsList)
            ->addColumn('deleteAction', function ($topicsList) {
                if (Auth::user()->role == 1)
                    return '<span class="tooltips" title="Delete Main Topic." data-placement="top">
                              <a href="javascript:;" data-topicId="' . $topicsList->topic_id . '" class="btn btn-danger delete-topic" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-course-topic/' . $topicsList->topic_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                else
                    return '<span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-course-topic/' . $topicsList->topic_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';

            })
            ->make(true);



    }

    public function deleteTopic(Request $request)
    {
        $result = DB::table('topic')
            ->where('topic_id', '=', $request->input('topicId'))
            ->delete();

        if ($result)
            echo json_encode(['status' => 'success', 'msg' => trans('message.MainTopichasbeendeleted')]);
        else
            echo json_encode(['status' => 'error', 'msg' => 'Sorry! Main Student has not been deleted']);
        die;

    }

}//End of Class