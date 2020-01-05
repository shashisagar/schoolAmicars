<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Redirect;
use View;



/**
 * Class SchoolCourseController
 */
class SchoolCourseController extends Controller
{
    public function manageTopicList(Request $request,$schoolId, $stageId, $courseId)
    {
        if ($request->isMethod('post')) {

            // dd("fffffffffffffffffffffffff");

            // dd($CourseTopicId);
            $CourseTopicId = $request->input('CourseTopicId');
            $utube_file = $request->input('utube_file');

            $simpleLink_file = $request->input('simpleLink_file');
            $fileType = $request->input('fileType');


            if (!empty($utube_file)) {

                // dd("yyyyyyyyyyyyyyyyyyyyyyy");

                $utube_link = $request->input('utube_link');

                // dd($utube_link);

                $validator = Validator::make($request->all(), [
                    'utube_link' => ['required', 'regex:^(http(s)??\:\/\/)?(www\.)?((youtube\.com\/watch\?v=)|(youtu.be\/))([a-zA-Z0-9\-_])+$^']

                ]);

                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["status" => 'error', 'msg' => 'Please upload the you tube file.'])
                        ->withErrors($validator)
                        ->withInput();
                } else {


                    DB::table('topic')
                        ->where('topic_id', $CourseTopicId)
                        ->update(['topic_utube_file_link' => $utube_link]);
                }
            }


            if (!empty($simpleLink_file)) {
                //  dd("yyyyyyyyyyyyyyyyyyyyyyy");

                $topic_simple_link = $request->input('topic_simple_link');
                //dd($topic_simple_link);

                $validator = Validator::make($request->all(), [
                    'topic_simple_link' => ['required', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/']

                ]);

                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["status" => 'error', 'msg' => 'Please copy/paste the Simple Link/Url only.'])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    DB::table('topic')
                        ->where('topic_id', $CourseTopicId)
                        ->update(['topic_simple_file_link' => $topic_simple_link]);

                }
            }

            if (!empty($fileType)) {
                $file = $request->file('upload_file');
//                $fileType = $request->input('fileType');

                if ($file)
                    $fileExtension = strtolower($file->getClientOriginalExtension());
                else
                    $fileExtension = '';

                $inputData = [
                    'upload_file' => $fileExtension,
                ];

                if ($fileType == 'topic_ppt')
                    $rules = [
                        'upload_file' => 'required|in:ppt,',
                    ];
                else if ($fileType == 'topic_msword')
                    $rules = [
                        'upload_file' => 'required|in:docx,doc,',
                    ];
                else if ($fileType == 'topic_pdf')
                    $rules = [
                        'upload_file' => 'required|in:pdf,',
                    ];


                $validator = Validator::make($inputData, $rules);

                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["status" => 'error', 'msg' => 'Please upload the file according to format.'])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $fileName = 'course-topic-' . $fileType . '-' . $CourseTopicId . '.' . $fileExtension;

                    $file->move(storage_path() . '/uploads/courseTopicFiles', $fileName);
                    $fileUrl = storage_path() . '/uploads/courseTopicFiles/' . $fileName;

                    $data = array();

                    if ($fileType == 'topic_ppt')
                        $data['topic_powerpoint_file_link'] = $fileUrl;
                    else if ($fileType == 'topic_msword')
                        $data['topic_word_file_link'] = $fileUrl;
                    else if ($fileType == 'topic_pdf')
                        $data['topic_pdf_file_link'] = $fileUrl;


                    DB::table('topic')
                        ->where('topic_id', '=', $CourseTopicId)
                        ->update($data);
                }
            }
        }

        return view('Admin::schoolCourse.manageTopicList', ['schoolId' => $schoolId, 'stageId' => $stageId, 'courseId' => $courseId]);
    }

    public function manageTermList(Request $request,$schoolId, $stageId, $courseId, $topicId)
    {
        if ($request->isMethod('post')) {

            // dd("yyyyyyyyyyyyyyyyyyyy");

            $TopicTermRuleId = $request->input('TopicTermRuleId');
            $term_utube_file = $request->input('term_utube_file');
            $term_simpleLink_file = $request->input('term_simpleLink_file');

//            print_r($term_utube_file);
//            die;
//
//            print_r($term_simpleLink_file);
//            die;

            $fileType = $request->input('fileType');

            if (!empty($term_utube_file)) {
                $term_utube_link = $request->input('term_utube_link');
                $validator = Validator::make($request->all(), [
                    'term_utube_link' => ['required', 'regex:^(http(s)??\:\/\/)?(www\.)?((youtube\.com\/watch\?v=)|(youtu.be\/))([a-zA-Z0-9\-_])+$^']

                ]);

                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["status" => 'error', 'msg' => 'Please upload the you tube file.'])
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    DB::table('scientific_term_per_topic')
                        ->where('scientific_term_per_topic_id', $TopicTermRuleId)
                        ->update(['term_utube_file_link' => $term_utube_link]);
                }
            }

            if (!empty($term_simpleLink_file)) {
                $term_simple_link = $request->input('term_simple_link');
                $validator = Validator::make($request->all(), [
                    'term_simple_link' => ['required', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/']

                ]);

                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["status" => 'error', 'msg' => 'Please copy/paste the Simple Link/Url only.'])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    DB::table('scientific_term_per_topic')
                        ->where('scientific_term_per_topic_id', $TopicTermRuleId)
                        ->update(['term_simple_file_link' => $term_simple_link]);
                }
            }

            if (!empty($fileType)) {
                $file = $request->file('upload_file');

                if ($file)
                    $fileExtension = strtolower($file->getClientOriginalExtension());
                else
                    $fileExtension = '';

                $inputData = [
                    'upload_file' => $fileExtension,
                ];

                if ($fileType == 'term_ppt')
                    $rules = [
                        'upload_file' => 'required|in:pptx,',
                    ];
                else if ($fileType == 'term_msword')
                    $rules = [
                        'upload_file' => 'required|in:docx,doc,',
                    ];
                else if ($fileType == 'term_pdf')
                    $rules = [
                        'upload_file' => 'required|in:pdf,',
                    ];

                $validator = Validator::make($inputData, $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["status" => 'error', 'msg' => 'Please upload the file according to format.'])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $fileName = 'topic-term-' . $fileType . '-' . $TopicTermRuleId . '.' . $fileExtension;
                    $file->move(storage_path() . '/uploads/topicTermRuleFiles', $fileName);
                    $fileUrl = storage_path() . '/uploads/topicTermRuleFiles/' . $fileName;
                    $data = array();
                    if ($fileType == 'term_ppt')
                        $data['term_powerpoint_file_link'] = $fileUrl;
                    else if ($fileType == 'term_msword')
                        $data['term_word_file_link'] = $fileUrl;
                    else if ($fileType == 'term_pdf')
                        $data['term_pdf_file_link'] = $fileUrl;

                    DB::table('scientific_term_per_topic')
                        ->where('scientific_term_per_topic_id', $TopicTermRuleId)
                        ->update($data);
                }
            }
        }

        return view('Admin::schoolCourse.manageTermList', ['schoolId' => $schoolId, 'stageId' => $stageId, 'courseId' => $courseId, 'topicId' => $topicId]);
    }

    public function addSchoolCourse(Request $request)
    {
       // dd("ffffffffffffffffffff");

//        $tr = new TranslateClient('en', 'he');
//        print_r($tr->setSource('en')->setTarget('he')->translate('login'));
//        die;

        if (Auth::user()->role == 1) {
            if ($request->isMethod('post')) {
                $rules = [
                    'semesterA_course_name' => 'required',
                    'semesterA_teacher_name' => 'required',
                    'semesterB_course_name' => 'required',
                    'semesterB_teacher_name' => 'required',
                    'teaching_stage' => 'required',
                    'school' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => 'Please correct the following errors.'])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $semesterA_course_name = $request->input('semesterA_course_name');
                    $semesterA_teacher_name = $request->input('semesterA_teacher_name');
                    $semesterB_course_name = $request->input('semesterB_course_name');
                    $semesterB_teacher_name = $request->input('semesterB_teacher_name');
                    $teaching_stage = $request->input('teaching_stage');
                    $school = $request->input('school');

//                print_r($semesterA_course_name);
//                die;

                    $course_relation_id=DB::table('courses_relation')->insertGetId(
                        ['schools_id' => $school, 'teaching_stage_id' => $teaching_stage, 'courses_id_a' => $semesterA_course_name,
                            'courses_id_b' => $semesterB_course_name, 'teachers_id_a' => $semesterA_teacher_name,
                            'teachers_id_b' => $semesterB_teacher_name]
                    );

                    DB::table('coursesteacher')->insert(
                        ['schools_id' => $school, 'teaching_stage_id' => $teaching_stage, 'semester' => 'A',
                            'courses_id' => $semesterA_course_name, 'teachers_id' => $semesterA_teacher_name,'courses_relation_id'=>$course_relation_id
                           ]
                    );

                    DB::table('coursesteacher')->insert(
                        ['schools_id' => $school, 'teaching_stage_id' => $teaching_stage, 'semester' => 'B',
                            'courses_id' => $semesterB_course_name, 'teachers_id' => $semesterB_teacher_name,'courses_relation_id'=>$course_relation_id
                        ]
                    );


                    return Redirect::back()->with(['code' => '200', 'message' => 'New Courses/Teacher has been added.']);
                }
            }

            $schoolList = DB::table('schools')
                ->select('schools_id', 'name')
                ->get();


            $teacherList = DB::table('teachers')
                ->select('teachers_id', 'teacher_name')
                ->get();

            $courseList = DB::table('courses')
                ->select('courses_id', 'course_name')
                ->get();

            $teaching_stage = DB::table('teaching_stage')
                ->select('teaching_stage_id', 'name')
                ->get();

            return view('Admin::schoolCourse.addSchoolCourse', ['schoolList' => $schoolList, 'teacherList' => $teacherList,
                'courseList' => $courseList, 'teaching_stage' => $teaching_stage]);
        }
        else{

           // dd("iiiiiiiiiiiiiiiiiiiiiii");
            if ($request->isMethod('post')) {
                $rules = [
                    'semesterA_course_name' => 'required',
                    'semesterA_teacher_name' => 'required',
                    'semesterB_course_name' => 'required',
                    'semesterB_teacher_name' => 'required',
                    'teaching_stage' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => 'Please correct the following errors.'])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $semesterA_course_name = $request->input('semesterA_course_name');
                    $semesterA_teacher_name = $request->input('semesterA_teacher_name');
                    $semesterB_course_name = $request->input('semesterB_course_name');
                    $semesterB_teacher_name = $request->input('semesterB_teacher_name');
                    $teaching_stage = $request->input('teaching_stage');
                    $school=Auth::user()->schools_id;

//                print_r($semesterA_course_name);
//                die;
                    DB::table('courses_relation')->insert(
                        ['schools_id' => $school, 'teaching_stage_id' => $teaching_stage, 'courses_id_a' => $semesterA_course_name,
                            'courses_id_b' => $semesterB_course_name, 'teachers_id_a' => $semesterA_teacher_name,
                            'teachers_id_b' => $semesterB_teacher_name]
                    );

                    DB::table('coursesteacher')->insert(
                        ['schools_id' => $school, 'teaching_stage_id' => $teaching_stage, 'semester' => 'A',
                            'courses_id' => $semesterA_course_name, 'teachers_id' => $semesterA_teacher_name,
                        ]
                    );

                    DB::table('coursesteacher')->insert(
                        ['schools_id' => $school, 'teaching_stage_id' => $teaching_stage, 'semester' => 'B',
                            'courses_id' => $semesterB_course_name, 'teachers_id' => $semesterB_teacher_name,
                        ]
                    );

                    return Redirect::back()->with(['code' => '200', 'message' => 'New Courses/Teacher has been added.']);
                }
            }

            $schools_id=Auth::user()->schools_id;
            $teacherList = DB::table('teachers')
                ->where('schools_id',$schools_id)
                ->select('teachers_id', 'teacher_name')
                ->get();


//            print_r($teacherList);
//            die;

            $courseList = DB::table('courses')
                ->where('schools_id',$schools_id)
                ->select('courses_id', 'course_name')
                ->get();

//            print_r($courseList);
//            die;

            $teaching_stage = DB::table('teaching_stage')
                ->select('teaching_stage_id', 'name')
                ->get();

//            echo "<pre>";
//            print_r($teaching_stage);
//            die;

            return view('Admin::schoolCourse.addSchoolCourse', ['teacherList' => $teacherList,
                'courseList' => $courseList, 'teaching_stage' => $teaching_stage]);

        }

    }

    public function editSchoolCourse(Request $request, $courses_relation_id)
    {
        if (Auth::user()->role == 1) {
            $courses_relationDetails = DB::table('courses_relation')
                ->where('courses_relation_id', '=', $courses_relation_id)
                ->first();

            $schools_id = $courses_relationDetails->schools_id;
            $teaching_stage_id = $courses_relationDetails->teaching_stage_id;
            $courses_id_a = $courses_relationDetails->courses_id_a;
            $courses_id_b = $courses_relationDetails->courses_id_b;
            $teachers_id_a = $courses_relationDetails->teachers_id_a;
            $teachers_id_b = $courses_relationDetails->teachers_id_b;

            $schoolName = DB::table('schools')
                ->where('schools_id', $schools_id)
                ->get();

            $teachingName = DB::table('teaching_stage')
                ->where('teaching_stage_id', $teaching_stage_id)
                ->get();


            $coursesA = DB::table('courses')
                ->where('courses_id', $courses_id_a)
                ->get();

            $coursesB = DB::table('courses')
                ->where('courses_id', $courses_id_b)
                ->get();

            $teacherA = DB::table('teachers')
                ->where('teachers_id', $teachers_id_a)
                ->get();

            $teacherB = DB::table('teachers')
                ->where('teachers_id', $teachers_id_b)
                ->get();


            if ($request->isMethod('post')) {

                //dd("ffffffffffffffff");
                $rules = [
                    'semesterA_course_name' => 'required',
                    'semesterA_teacher_name' => 'required',
                    'semesterB_course_name' => 'required',
                    'semesterB_teacher_name' => 'required',
                    'teaching_stage' => 'required',
                    'school' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => 'Please correct the following errors.'])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    // dd("ggggggggggggggg");
                    $semesterA_course_name = $request->input('semesterA_course_name');
                    $semesterA_teacher_name = $request->input('semesterA_teacher_name');
                    $semesterB_course_name = $request->input('semesterB_course_name');
                    $semesterB_teacher_name = $request->input('semesterB_teacher_name');
                    $teaching_stage = $request->input('teaching_stage');
                    $school = $request->input('school');

//                print_r($semesterA_course_name);
//                die;
                    DB::table('courses_relation')
                        ->where('courses_relation_id', $courses_relation_id)
                        ->update(['schools_id' => $school, 'teaching_stage_id' => $teaching_stage, 'courses_id_a' => $semesterA_course_name,
                            'courses_id_b' => $semesterB_course_name, 'teachers_id_a' => $semesterA_teacher_name,
                            'teachers_id_b' => $semesterB_teacher_name]);



                    DB::table('coursesteacher')
                        ->where('courses_relation_id', $courses_relation_id)
                        ->where('semester','A')
                        ->update(['schools_id' => $school, 'teaching_stage_id' => $teaching_stage, 'courses_id' => $semesterA_course_name,
                            'teachers_id' => $semesterA_teacher_name,
                            ]);

                    DB::table('coursesteacher')
                        ->where('courses_relation_id', $courses_relation_id)
                        ->where('semester','B')
                        ->update(['schools_id' => $school, 'teaching_stage_id' => $teaching_stage, 'courses_id' => $semesterB_course_name,
                            'teachers_id' => $semesterB_teacher_name,
                        ]);


                    return Redirect::back()->with(['code' => '200', 'message' => 'Courses/Teacher has been updated.']);
                }
            }

            $schoolList = DB::table('schools')
                ->select('schools_id', 'name')
                ->get();


            $teacherList = DB::table('teachers')
                ->select('teachers_id', 'teacher_name')
                ->get();

            $courseList = DB::table('courses')
                ->select('courses_id', 'course_name')
                ->get();

            $teaching_stage = DB::table('teaching_stage')
                ->select('teaching_stage_id', 'name')
                ->get();

            return view('Admin::schoolCourse.editSchoolCourse', ['schoolList' => $schoolList, 'teacherList' => $teacherList,
                'courseList' => $courseList, 'teaching_stage' => $teaching_stage
                , 'teachingName' => $teachingName, 'coursesA' => $coursesA,
                'coursesB' => $coursesB, 'teacherA' => $teacherA, 'teacherB' => $teacherB])->with('schoolName', $schoolName);

//
//            return view('Admin::schoolCourse.editSchoolCourse', ['schoolList' => $schoolList, 'teacherList' => $teacherList,
//                'courseList' => $courseList, 'teaching_stage' => $teaching_stage
//                ,'courses_relationDetails'=> $courses_relationDetails ]);





        }
        else{

            $school=Auth::user()->schools_id;


            $courses_relationDetails = DB::table('courses_relation')
                ->where('courses_relation_id', '=', $courses_relation_id)
                ->first();

            $schools_id = $courses_relationDetails->schools_id;
            $teaching_stage_id = $courses_relationDetails->teaching_stage_id;
            $courses_id_a = $courses_relationDetails->courses_id_a;
            $courses_id_b = $courses_relationDetails->courses_id_b;
            $teachers_id_a = $courses_relationDetails->teachers_id_a;
            $teachers_id_b = $courses_relationDetails->teachers_id_b;

            $schoolName = DB::table('schools')
                ->where('schools_id', $schools_id)
                ->get();

            $teachingName = DB::table('teaching_stage')
                ->where('teaching_stage_id', $teaching_stage_id)
                ->get();


            $coursesA = DB::table('courses')
                ->where('courses_id', $courses_id_a)
                ->get();

            $coursesB = DB::table('courses')
                ->where('courses_id', $courses_id_b)
                ->get();

            $teacherA = DB::table('teachers')
                ->where('teachers_id', $teachers_id_a)
                ->get();

            $teacherB = DB::table('teachers')
                ->where('teachers_id', $teachers_id_b)
                ->get();


            if ($request->isMethod('post')) {

                //dd("ffffffffffffffff");
                $rules = [
                    'semesterA_course_name' => 'required',
                    'semesterA_teacher_name' => 'required',
                    'semesterB_course_name' => 'required',
                    'semesterB_teacher_name' => 'required',
                    'teaching_stage' => 'required',

                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => 'Please correct the following errors.'])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    // dd("ggggggggggggggg");
                    $semesterA_course_name = $request->input('semesterA_course_name');
                    $semesterA_teacher_name = $request->input('semesterA_teacher_name');
                    $semesterB_course_name = $request->input('semesterB_course_name');
                    $semesterB_teacher_name = $request->input('semesterB_teacher_name');
                    $teaching_stage = $request->input('teaching_stage');


//                print_r($semesterA_course_name);
//                die;
                    DB::table('courses_relation')
                        ->where('courses_relation_id', $courses_relation_id)
                        ->update(['schools_id' => $school, 'teaching_stage_id' => $teaching_stage, 'courses_id_a' => $semesterA_course_name,
                            'courses_id_b' => $semesterB_course_name, 'teachers_id_a' => $semesterA_teacher_name,
                            'teachers_id_b' => $semesterB_teacher_name]);


                    return Redirect::back()->with(['code' => '200', 'message' => 'Courses/Teacher has been updated.']);
                }
            }

            $teacherList = DB::table('teachers')
                ->where('schools_id',$school)
                ->select('teachers_id', 'teacher_name')
                ->get();

            $courseList = DB::table('courses')
                ->where('schools_id',$school)
                ->select('courses_id', 'course_name')
                ->get();

            $teaching_stage = DB::table('teaching_stage')
                ->select('teaching_stage_id', 'name')
                ->get();

            return view('Admin::schoolCourse.editSchoolCourse', ['teacherList' => $teacherList,
                'courseList' => $courseList, 'teaching_stage' => $teaching_stage
                , 'teachingName' => $teachingName, 'coursesA' => $coursesA,
                'coursesB' => $coursesB, 'teacherA' => $teacherA, 'teacherB' => $teacherB])->with('schoolName', $schoolName);


        }
    }

    public function schoolCourseAjaxHandler(Request $request)
    {
        $method = $request->input('method');

        $schoolID = $request->input('schools_id');
        //dd($schoolID);

        //dd($method);
        if ($method) {
            switch ($method) {
                case 'deleteTopicScientificTermRule':

                    $result = DB::table('scientific_term_per_topic')
                        ->where('scientific_term_per_topic_id', '=', $request->input('dataTopicScientificTermRuleId'))
                        ->delete();

                    if ($result)
                        echo json_encode(['status' => 'success', 'msg' => 'courses Topic has been successfully deleted']);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! Main Student has not been deleted']);
                    die;
                    break;
                case 'deleteCourseTopic':

                    $result = DB::table('topic')
                        ->where('topic_id', '=', $request->input('datatopicId'))
                        ->delete();

                    if ($result)
                        echo json_encode(['status' => 'success', 'msg' => 'courses Topic has been successfully deleted']);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! Main Student has not been deleted']);
                    die;
                    break;
                case 'deleteCourseTeacher':

                    $result = DB::table('courses_relation')
                        ->where('courses_relation_id', '=', $request->input('coursesRelationId'))
                        ->delete();

                    $result = DB::table('coursesteacher')
                        ->where('courses_relation_id', '=', $request->input('coursesRelationId'))
                        ->delete();

                    if ($result)
                        echo json_encode(['status' => 'success', 'msg' => 'courses/Teacher has been successfully deleted']);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! Main Student has not been deleted']);
                    die;
                    break;
                case 'allSchoolCourseList':


                    if (Auth::user()->role == 1) {

                        if (!empty($schoolID)) {

                          //  dd($schoolID);
                            // dd("gggggggggggggggg");
                            $schoolCourseList = DB::table('courses_relation')
                                ->join('schools', 'courses_relation.schools_id', '=', 'schools.schools_id')
                                ->join('teaching_stage', 'courses_relation.teaching_stage_id', '=', 'teaching_stage.teaching_stage_id')
                                ->join('courses as coursesA', 'courses_relation.courses_id_a', '=', 'coursesA.courses_id')
                                ->join('courses as coursesB', 'courses_relation.courses_id_b', '=', 'coursesB.courses_id')
                                ->join('teachers as teachersA', 'courses_relation.teachers_id_a', '=', 'teachersA.teachers_id')
                                ->join('teachers as teachersB', 'courses_relation.teachers_id_b', '=', 'teachersB.teachers_id')
                                ->where('courses_relation.schools_id', '=', $schoolID)
                                ->where('schools.schools_id', '=', $schoolID)
                                ->select('courses_relation.courses_relation_id',
                                    'courses_relation.schools_id', 'schools.name as school_name',
                                    'courses_relation.teaching_stage_id', 'teaching_stage.name as teaching_stage_name',
                                    'courses_relation.courses_id_a', 'coursesA.course_name as course_name_a',
                                    'courses_relation.courses_id_b', 'coursesB.course_name as course_name_b',
                                    'courses_relation.teachers_id_a', 'teachersA.teacher_name as teacher_name_a',
                                    'courses_relation.teachers_id_b', 'teachersB.teacher_name as teacher_name_b',
                                    'courses_relation.pdf_file_link_a', 'courses_relation.pdf_file_link_b',
                                    'courses_relation.word_file_link_a', 'courses_relation.word_file_link_b');

                        } else {

                            $schoolCourseList = DB::table('courses_relation')
                                ->join('schools', 'courses_relation.schools_id', '=', 'schools.schools_id')
                                ->join('teaching_stage', 'courses_relation.teaching_stage_id', '=', 'teaching_stage.teaching_stage_id')
                                ->join('courses as coursesA', 'courses_relation.courses_id_a', '=', 'coursesA.courses_id')
                                ->join('courses as coursesB', 'courses_relation.courses_id_b', '=', 'coursesB.courses_id')
                                ->join('teachers as teachersA', 'courses_relation.teachers_id_a', '=', 'teachersA.teachers_id')
                                ->join('teachers as teachersB', 'courses_relation.teachers_id_b', '=', 'teachersB.teachers_id')
                                ->select('courses_relation.courses_relation_id',
                                    'courses_relation.schools_id', 'schools.name as school_name',
                                    'courses_relation.teaching_stage_id', 'teaching_stage.name as teaching_stage_name',
                                    'courses_relation.courses_id_a', 'coursesA.course_name as course_name_a',
                                    'courses_relation.courses_id_b', 'coursesB.course_name as course_name_b',
                                    'courses_relation.teachers_id_a', 'teachersA.teacher_name as teacher_name_a',
                                    'courses_relation.teachers_id_b', 'teachersB.teacher_name as teacher_name_b',
                                    'courses_relation.pdf_file_link_a', 'courses_relation.pdf_file_link_b',
                                    'courses_relation.word_file_link_a', 'courses_relation.word_file_link_b');


                        }
                    }


                    else {
                        $schoolCourseList = DB::table('courses_relation')
                            ->join('schools', 'courses_relation.schools_id', '=', 'schools.schools_id')
                            ->join('teaching_stage', 'courses_relation.teaching_stage_id', '=', 'teaching_stage.teaching_stage_id')
                            ->join('courses as coursesA', 'courses_relation.courses_id_a', '=', 'coursesA.courses_id')
                            ->join('courses as coursesB', 'courses_relation.courses_id_b', '=', 'coursesB.courses_id')
                            ->join('teachers as teachersA', 'courses_relation.teachers_id_a', '=', 'teachersA.teachers_id')
                            ->join('teachers as teachersB', 'courses_relation.teachers_id_b', '=', 'teachersB.teachers_id')
                            ->where('courses_relation.schools_id', '=', Auth::user()->schools_id)
                            ->select('courses_relation.courses_relation_id',
                                'courses_relation.schools_id', 'schools.name as school_name',
                                'courses_relation.teaching_stage_id', 'teaching_stage.name as teaching_stage_name',
                                'courses_relation.courses_id_a', 'coursesA.course_name as course_name_a',
                                'courses_relation.courses_id_b', 'coursesB.course_name as course_name_b',
                                'courses_relation.teachers_id_a', 'teachersA.teacher_name as teacher_name_a',
                                'courses_relation.teachers_id_b', 'teachersB.teacher_name as teacher_name_b',
                                'courses_relation.pdf_file_link_a', 'courses_relation.pdf_file_link_b',
                                'courses_relation.word_file_link_a', 'courses_relation.word_file_link_b');
                    }

                    return Datatables::of($schoolCourseList)
                        ->addColumn('semesterA', function ($schoolCourseList) {

//                            return '<span class="tooltips" title="Add Word Document" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($schoolCourseList->word_file_link_a == NULL ? 'msword_gray.png' : 'msword_color.png') . '" width="20px" data-toggle="modal" data-target="#msword_a" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="file" data-id='.$schoolCourseList->courses_relation_id.' id="mymsword_a"></span>
//                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="tooltips" title="Add a PDF" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($schoolCourseList->pdf_file_link_a == NULL ? 'pdf_gray.png' : 'pdf_color.png') . '" width="20px" data-toggle="modal" data-target="#pdf_a" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="file" data-id='.$schoolCourseList->courses_relation_id.' id="mypdf_a"> ( ' . $schoolCourseList->teacher_name_a . ' )</span>
//                            <p data-toggle="modal" data-id='. $schoolCourseList->schools_id.' data-course='. $schoolCourseList->courses_id_a.' data-ts='. $schoolCourseList->teaching_stage_id.'  class="open-AddTopicDialog btn btn-primary" href="#addTopicDialog">' . $schoolCourseList->course_name_a . '</p>';



//
//                            return '<span class="tooltips" title="Add Word Document" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($schoolCourseList->word_file_link_a == NULL ? 'msword_gray.png' : 'msword_color.png') . '" width="20px" data-toggle="modal" data-target="#msword_a" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="file" data-id='.$schoolCourseList->courses_relation_id.' id="mymsword_a"></span>
//                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="tooltips" title="Add a PDF" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($schoolCourseList->pdf_file_link_a == NULL ? 'pdf_gray.png' : 'pdf_color.png') . '" width="20px" data-toggle="modal" data-target="#pdf_a" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="file" data-id='.$schoolCourseList->courses_relation_id.' id="mypdf_a"> </span>
//                          <div class="mycustomclass btn btn-primary">  <p data-toggle="modal" data-id='. $schoolCourseList->schools_id.' data-course='. $schoolCourseList->courses_id_a.' data-ts='. $schoolCourseList->teaching_stage_id.'  class="open-AddTopicDialog " href="#addTopicDialog">' . $schoolCourseList->course_name_a .'</p>'.'( '  .$schoolCourseList->teacher_name_a .' )</div>';




                            return '<span class="tooltips" title="Add Word Document" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($schoolCourseList->word_file_link_a == NULL ? 'msword_gray.png' : 'msword_color.png') . '" width="20px" data-toggle="modal" data-target="#msword_a" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="file" data-id='.$schoolCourseList->courses_relation_id.' id="mymsword_a"></span>
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="tooltips" title="Add a PDF" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($schoolCourseList->pdf_file_link_a == NULL ? 'pdf_gray.png' : 'pdf_color.png') . '" width="20px" data-toggle="modal" data-target="#pdf_a" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="file" data-id='.$schoolCourseList->courses_relation_id.' id="mypdf_a"> </span>
                          <div data-toggle="modal" data-id='. $schoolCourseList->schools_id.' data-course='. $schoolCourseList->courses_id_a.' data-ts='. $schoolCourseList->teaching_stage_id.'  class="open-AddTopicDialog mycustomclass btn btn-primary" href="#addTopicDialog">  <p >' . $schoolCourseList->course_name_a .'</p>'.'( '  .$schoolCourseList->teacher_name_a .' )</div>';


                        })
                        ->addColumn('semesterB', function ($schoolCourseList) {


                            return '<span class="tooltips" title="Add Word Document" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($schoolCourseList->word_file_link_b == NULL ? 'msword_gray.png' : 'msword_color.png') . '" width="20px" data-toggle="modal" data-target="#msword_b" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="file" data-id='.$schoolCourseList->courses_relation_id.' id="mymsword_b"></span>
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="tooltips" title="Add a PDF" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($schoolCourseList->pdf_file_link_b == NULL ? 'pdf_gray.png' : 'pdf_color.png') . '" width="20px" data-toggle="modal" data-target="#pdf_b" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="file" data-id='.$schoolCourseList->courses_relation_id.' id="mypdf_b"> </span>
                          <div data-toggle="modal" data-id='. $schoolCourseList->schools_id.' data-course='. $schoolCourseList->courses_id_b.' data-ts='. $schoolCourseList->teaching_stage_id.'  class="open-AddTopicDialog mycustomclass btn btn-primary" href="#addTopicDialog">  <p >' . $schoolCourseList->course_name_b .'</p>'.'( '  .$schoolCourseList->teacher_name_b .' )</div>';


//
//                            return '<span class="tooltips" title="Add Word Document" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($schoolCourseList->word_file_link_b == NULL ? 'msword_gray.png' : 'msword_color.png') . '" width="20px" data-toggle="modal" data-target="#msword_b" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="file" data-id='.$schoolCourseList->courses_relation_id.' id="mymsword_b"></span>
//                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="tooltips" title="Add a PDF" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($schoolCourseList->pdf_file_link_b == NULL ? 'pdf_gray.png' : 'pdf_color.png') . '" width="20px" data-toggle="modal" data-target="#pdf_b" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="file" data-id='.$schoolCourseList->courses_relation_id.' id="mypdf_b"> ( ' . $schoolCourseList->teacher_name_b . ' )</span>
//                            <p data-toggle="modal" data-id='. $schoolCourseList->schools_id.' data-course='. $schoolCourseList->courses_id_b.' data-ts='. $schoolCourseList->teaching_stage_id.'  class="open-AddTopicDialog btn btn-primary" href="#addTopicDialog">' . $schoolCourseList->course_name_b . '</p>';

                        })
                        ->addColumn('deleteAction', function ($schoolCourseList) {
                            if (Auth::user()->role == 1)
                                return '<span class="tooltips" title="Delete School Course" data-placement="top">
                              <a href="javascript:;" data-coursesRelationId="' . $schoolCourseList->courses_relation_id . '" class="btn btn-danger delete-schoolCourse" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit School Course Detail." data-placement="top">
                              <a href="/edit-school-course/' . $schoolCourseList->courses_relation_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                            else
                                return '<span class="tooltips" title="Edit School Course Detail." data-placement="top">
                              <a href="/edit-school-course/' . $schoolCourseList->courses_relation_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                        })
                        ->make(true);
                    break;
                case 'allTopicList':
                  //  dd("fffffffffffffffffff");
//                    $stageId=$request->input('stageId');
//                  dd($stageId);

                    DB::statement(DB::raw('set @rownum=0'));

                    $topicList = DB::table('topic')
                        ->where('schools_id', '=', $request->input('schoolId'))
//                        ->where('teaching_stage_id', '=', $request->input('stageId'))
                        ->where('courses_id', '=', $request->input('courseId'))
                        ->select('topic_id', 'topic_name', 'schools_id', 'teaching_stage_id', 'courses_id',
                            'topic_pdf_file_link','topic_word_file_link',
                            'topic_powerpoint_file_link','topic_simple_file_link',
                            'topic_utube_file_link',DB::raw('@rownum  := @rownum  + 1 AS rownum')
                            );
//                        ->get();

//                     print_r($topicList);
//                     die;

                    return Datatables::of($topicList)
                        ->addColumn('files', function ($topicList) {
                            return '<span class="tooltips" title="Open Scientific Term& Rule." data-placement="top" style="cursor: pointer;"> <img src="/assets/images/icons8-My Topic-50.png" width="20px" data-toggle="modal" data-id='. $topicList->schools_id.' data-course='. $topicList->courses_id.' data-ts='. $topicList->teaching_stage_id.' data-ti='. $topicList->topic_id.'  class="open-AddTermDialog" href="#addTermDialog"> ' . ' </span>&nbsp;&nbsp;&nbsp;
                        
 <span class="tooltips" title="Add YouTube Link" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($topicList->topic_utube_file_link == NULL ? 'utube_gray.png' : 'utube_color.png') . '" width="20px" data-toggle="modal" data-target="#topic_utube" data-topicId="' . $topicList->topic_id . '" class="file" id="utube'.$topicList->topic_id .'" data-id='. $topicList->topic_id.'></span>
   &nbsp;&nbsp;&nbsp; <span class="tooltips" title="Add an Internet Link" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($topicList->topic_simple_file_link == NULL ? 'simpleLink_gray.png' : 'simpleLink_color.png') . '" width="20px" data-toggle="modal" data-target="#topic_simpleLink" data-topicId="' . $topicList->topic_id . '" class="file" id="link'.$topicList->topic_id .'" data-id='. $topicList->topic_id.'></span>
   
 &nbsp;&nbsp;&nbsp;<span class="tooltips" title="Add PowerPoint presentation" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($topicList->topic_powerpoint_file_link == NULL ? 'ppt_gray.png' : 'ppt_color.png') . '" width="20px" data-toggle="modal" data-target="#topic_ppt" data-topicId="' . $topicList->topic_id . '" class="file" id="ppt'.$topicList->topic_id .'" data-id='. $topicList->topic_id.'> </span>&nbsp;&nbsp;&nbsp;
 
 
 <span class="tooltips" title="Add word document" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($topicList->topic_word_file_link == NULL ? 'msword_gray.png' : 'msword_color.png') . '" width="20px" data-toggle="modal" data-target="#topic_msword" data-topicId="' . $topicList->topic_id . '" class="file" id="word'.$topicList->topic_id .'" data-id='. $topicList->topic_id.'></span>
 &nbsp;&nbsp;&nbsp; <span class="tooltips" title="Add a PDF" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($topicList->topic_pdf_file_link == NULL ? 'pdf_gray.png' : 'pdf_color.png') . '" width="20px" data-toggle="modal" data-target="#topic_pdf" data-topicId="' . $topicList->topic_id . '" class="file" id="pdf'.$topicList->topic_id .'" data-id='. $topicList->topic_id.'></span>';
                        })

                        ->addColumn('topicId', function ($topicList) {
                            return  $topicList->topic_id;
                        })

                        ->addColumn('deleteAction', function ($topicList) {
                            if (Auth::user()->role == 1)
                                return '<span class="tooltips" title="Delete Course Topic" data-placement="top">
                              <a href="javascript:;" data-topicId="' . $topicList->topic_id . '" class="btn btn-danger delete-CourseTopic" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit School Course Detail." data-placement="top">
                              <a href="/edit-course-topic/' . $topicList->schools_id . '/' . $topicList->teaching_stage_id . '/' . $topicList->courses_id . '/' . $topicList->topic_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                            else
                                $school=Auth::user()->schools_id;
                                return'<span class="tooltips" title="Edit School Course Detail." data-placement="top">
                              <a href="/edit-course-topic/' . $school . '/' . $topicList->teaching_stage_id . '/' . $topicList->courses_id . '/' . $topicList->topic_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                        })
                        ->make(true);
                    break;
                case 'allTermList':
                  //  dd("fffffffffffffff");

                    $termList = DB::table('scientific_term_per_topic')
                        ->join('scientific_terms', 'scientific_term_per_topic.scientific_terms_id', '=', 'scientific_terms.scientific_terms_id')
                        ->join('scientific_rule', 'scientific_term_per_topic.scientific_rule_id', '=', 'scientific_rule.scientific_rule_id')

                        ->where('scientific_term_per_topic.schools_id', '=', $request->input('schoolId'))
//                        ->where('scientific_rule.teaching_stage_id', '=', $request->input('stageId'))
                        ->where('scientific_term_per_topic.courses_id', '=', $request->input('courseId'))
                        ->where('scientific_term_per_topic.topic_id', '=', $request->input('topicId'))


                        ->select('scientific_term_per_topic.scientific_term_per_topic_id', 'scientific_rule.scientific_rule', 'scientific_terms.scientific_term'
                        ,'scientific_term_per_topic.term_utube_file_link',
                            'scientific_term_per_topic.term_simple_file_link',
                            'scientific_term_per_topic.term_ppt_file_link',
                            'scientific_term_per_topic.term_word_file_link',
                            'scientific_term_per_topic.term_pdf_file_link');

//
                    return Datatables::of($termList)

                        ->addColumn('files', function ($termList) {

                            return '<span class="tooltips" title="Add YouTube Link" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($termList->term_utube_file_link == NULL ? 'utube_gray.png' : 'utube_color.png') . '" width="20px" data-toggle="modal" data-target="#term_utube" data-topicTermRuleId="' . $termList->scientific_term_per_topic_id . '" class="file" id="utube'.$termList->scientific_term_per_topic_id .'" data-id='. $termList->scientific_term_per_topic_id.'></span>
      &nbsp;&nbsp;&nbsp; <span class="tooltips" title="Add an Internet Link" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($termList->term_simple_file_link == NULL ? 'simpleLink_gray.png' : 'simpleLink_color.png') . '" width="20px" data-toggle="modal" data-target="#term_simpleLink" data-topicTermRuleId="' . $termList->scientific_term_per_topic_id . '" class="file" id="link'.$termList->scientific_term_per_topic_id .'" data-id='. $termList->scientific_term_per_topic_id.'></span>
   
      &nbsp;&nbsp;&nbsp;<span class="tooltips" title="Add PowerPoint presentation" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($termList->term_ppt_file_link == NULL ? 'ppt_gray.png' : 'ppt_color.png') . '" width="20px" data-toggle="modal" data-target="#term_ppt" data-topicTermRuleId="' . $termList->scientific_term_per_topic_id . '" class="file" id="ppt'.$termList->scientific_term_per_topic_id .'" data-id='. $termList->scientific_term_per_topic_id.'></span> &nbsp;&nbsp;&nbsp;
 
 
    <span class="tooltips" title="Add word document" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($termList->term_word_file_link == NULL ? 'msword_gray.png' : 'msword_color.png') . '" width="20px" data-toggle="modal" data-target="#term_msword" data-topicTermRuleId="' . $termList->scientific_term_per_topic_id . '" class="file" id="word'.$termList->scientific_term_per_topic_id .'" data-id='. $termList->scientific_term_per_topic_id.'></span>
 &nbsp;&nbsp;&nbsp; <span class="tooltips" title="Add a PDF" data-placement="top" style="cursor: pointer;"><img src="/assets/images/' . ($termList->term_pdf_file_link == NULL ? 'pdf_gray.png' : 'pdf_color.png') . '" width="20px" data-toggle="modal" data-target="#term_pdf" data-topicTermRuleId="' . $termList->scientific_term_per_topic_id . '" class="file" id="pdf'.$termList->scientific_term_per_topic_id .'" data-id='. $termList->scientific_term_per_topic_id.'></span>';
                        })

//                        ->addColumn('deleteAction', function ($termList) {
//                            if (Auth::user()->role == 1)
//                                return '<span class="tooltips" title="Delete Course Topic" data-placement="top">
//                              <a href="javascript:;" data-topicScientificTermRuleId="' . $termList->scientific_term_per_topic_id . '" class="btn btn-danger delete-topicScientificTermRule" style="margin-left: 10%;">
//                                <i class="fa fa-trash-o"></i>
//                              </a>
//                            </span>
//                            <span class="tooltips" title="Edit School Course Detail." data-placement="top">
//                              <a href="/edit-topic-scientificTermRule/' . $termList->scientific_term_per_topic_id . '" class="btn btn-primary" style="margin-left: 10%;">
//                                <i class="fa fa-pencil-square-o"></i>
//                              </a>
//                            </span>';
//                            else
//                                return '<span class="tooltips" title="Edit School Course Detail." data-placement="top">
//                              <a href="/edit-topic-scientificTermRule/' . $termList->scientific_term_per_topic_id . '" class="btn btn-primary" style="margin-left: 10%;">
//                                <i class="fa fa-pencil-square-o"></i>
//                              </a>
//                            </span>';
//                        })
                        ->make(true);
                    break;
                default:
                    break;
            }
        }
    }


    public function editCourseTopic(Request $request,$schools_id,$teaching_stage_id,$courses_id,$topic_id)
    {

        $topicList = DB::table('topic')
            ->where('schools_id', '=', $schools_id)
            ->where('teaching_stage_id', '=', $teaching_stage_id)
            ->where('courses_id', '=', $courses_id)
            ->where('topic_id', '=', $topic_id)
            ->select('topic_id', 'topic_name')
            ->get();

//        print_r($topicList);
//        die;

        if ($request->isMethod('post')) {

            $rules = [
                'course_topic_name' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["code" => '400', 'message' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {

               $course_topic_name = $request->input('course_topic_name');

               $AlltopicList = DB::table('topic')
                    ->where('topic_id', '=', $topic_id)
                    ->update(['topic_name' => $course_topic_name]);


                return Redirect::back()->with(['code' => '200', 'message' => 'Topics has been updated.']);
            }
        }


        return view('Admin::schoolCourse.editCourseTopic')->with('topicList',$topicList);
    }


    public function editTopicScientificTermRule(Request $request,$scientific_term_per_topic_id)
    {
        $scientificTermRule = DB::table('scientific_term_per_topic')
            ->join('scientific_rule', 'scientific_term_per_topic.scientific_rule_id', '=', 'scientific_rule.scientific_rule_id')
            ->join('scientific_terms', 'scientific_term_per_topic.scientific_terms_id', '=', 'scientific_terms.scientific_terms_id')
            ->where('scientific_term_per_topic_id', '=', $scientific_term_per_topic_id)
            ->select('scientific_terms.scientific_term','scientific_terms.scientific_terms_id', 'scientific_rule.scientific_rule','scientific_rule.scientific_rule_id')
            ->get();

        if ($request->isMethod('post')) {

            $rules = [
                'scientific_term' => 'required',
                'scientific_rule'=>'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["code" => '400', 'message' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $scientific_term = $request->input('scientific_term');
                $scientific_rule = $request->input('scientific_rule');

                $scientific_term_id = $request->input('scientific_term_id');
                $scientific_rule_id = $request->input('scientific_rule_id');

                $scientific_terms_update = DB::table('scientific_terms')
                    ->where('scientific_terms_id', '=', $scientific_term_id)
                    ->update(['scientific_term' => $scientific_term]);

                $scientific_rule_update = DB::table('scientific_rule')
                    ->where('scientific_rule_id', '=', $scientific_rule_id)
                    ->update(['scientific_rule' => $scientific_rule]);


                return Redirect::back()->with(['code' => '200', 'message' => 'Scientific Terms/Rules has been updated.']);
            }
        }

        return view('Admin::schoolCourse.editTopicScientificTermRule')->with('scientificTermRule',$scientificTermRule);

    }


    public function coursesPerSchool(Request $request)
    {
        $school_id = $request->input('school_id');
        $allCourses = DB::table('courses')
                ->where('schools_id',$school_id)
                ->select('courses_id', 'course_name')
                ->get();

//        echo json_encode($allCourses);
//        return;

//        echo " <div class=\"col-sm-4\">";
        echo "<option value=''>------- Select --------</option>";
        foreach ($allCourses as $allCourses) {
            echo "<option value='".$allCourses->courses_id."'>".$allCourses->course_name."</option>";

        }
//        echo "</div>";
        die;

    }

    public function termCoursesPerSchool(Request $request)
    {
        $term_school_id = $request->input('term_school_id');
        $allCourses = DB::table('courses')
            ->where('schools_id',$term_school_id)
            ->select('courses_id', 'course_name')
            ->get();

//        echo " <div class=\"col-sm-4\">";
        echo "<option value=''>------- Select --------</option>";
        foreach ($allCourses as $allCourses) {
          echo "<option value='".$allCourses->courses_id."'>".$allCourses->course_name."</option>";

        }
//        echo "</div>";
        die;

    }


    public function topicPerCourses(Request $request)
    {
        $term_courses_id = $request->input('term_courses_id');
        $allTopics = DB::table('topic')
            ->where('courses_id',$term_courses_id)
            ->select('topic_id', 'topic_name')
            ->get();

        echo "<option value=''>------- Select --------</option>";
        foreach ($allTopics as $allTopics) {
            echo "<option value='".$allTopics->topic_id."'>".$allTopics->topic_name."</option>";

        }

        die;

    }

    public function normalTeacherPerSchool(Request $request)
    {
        $normal_school_id = $request->input('normal_school_id');

       // dd($normal_school_id);

        $allNormalTeacher = DB::table('teachers')
            ->where('schools_id',$normal_school_id)
            ->select('teachers_id', 'teacher_name')
            ->get();

//        print_r($allNormalTeacher);
//        die;

        echo "<option value=''>------- Select --------</option>";
        foreach ($allNormalTeacher as $allNormalTeacher) {
            echo "<option value='".$allNormalTeacher->teachers_id."'>".$allNormalTeacher->teacher_name."</option>";

        }
        die;

    }

    public function rulePerTerms(Request $request)
    {
        $term_topic_id = $request->input('term_topic_id');
        // dd($normal_school_id);

        $scientific_terms_id = DB::table('scientific_term_per_topic')
            ->where('topic_id',$term_topic_id)
            ->select('scientific_terms_id')
            ->first();


        $scientific_terms_id=$scientific_terms_id->scientific_terms_id;




        $Allterms = DB::table('scientific_terms')
            ->where('scientific_terms_id',$scientific_terms_id)
            ->get();



//        print_r($allNormalTeacher);
//        die;

        echo "<option value=''>------- Select --------</option>";
        foreach ($Allterms as $Allterms) {
            echo "<option value='".$Allterms->scientific_terms_id."'>".$Allterms->scientific_term."</option>";
        }
        die;
    }


    public function topicCourseName(Request $request)
    {
        $courseId=$request->courseId;

        $courseName = DB::table('courses')
            ->where('courses_id',$courseId)
            ->select('course_name','schools_id')
            ->first();

        $course_name=$courseName->course_name;
        $schools_id=$courseName->schools_id;

        $arr = array();

        $arr[0] = $course_name;

        $arr[1]=$schools_id;

        $arr[2]=$courseId;

        echo json_encode($arr);
        exit();

    }

    public function termRuleTopicName(Request $request)
    {
        $topicId=$request->topicId;

        $topicName = DB::table('topic')
            ->where('topic_id',$topicId)
            ->select('topic_name','schools_id','courses_id','topic_id')
            ->first();

        $topic_name=$topicName->topic_name;

        $schools_id=$topicName->schools_id;
        $courseId=$topicName->courses_id;



        $arr = array();
        $arr[0] = $topic_name;
        $arr[1]=$schools_id;

        $arr[2]=$courseId;
        $arr[3]=$topicId;


        echo json_encode($arr);
        exit();


    }


    public function getMswordfile(Request $request)
    {
        $adminid=$request->adminid;

        //die($adminid);

        $word_file_link_a = DB::table('courses_relation')
            ->where('courses_relation_id',$adminid)
            ->select('word_file_link_a')
            ->first();


        $word_file_link_a=$word_file_link_a->word_file_link_a;
        $arr = array();

        if(!empty($word_file_link_a)) {


            $arr[0] = env('APP_URL') . '/' . $word_file_link_a;

            echo json_encode($arr);
            exit();
        }
       else
       {
           $arr[0] = 1;
           echo json_encode($arr);
           exit();

       }


    }

    public function getmswordfileb(Request $request)
    {
        $mymsword_b=$request->mymsword_b;

        //die($adminid);

        $word_file_link_b = DB::table('courses_relation')
            ->where('courses_relation_id',$mymsword_b)
            ->select('word_file_link_b')
            ->first();


        $word_file_link_b=$word_file_link_b->word_file_link_b;
        $arr = array();

        if(!empty($word_file_link_b)) {


            $arr[0] = env('APP_URL') . '/' . $word_file_link_b;

            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }


    }

    public function getmypdfa(Request $request)
    {
        $mypdf_a=$request->mypdf_a;

        //die($adminid);

        $pdf_file_link_a = DB::table('courses_relation')
            ->where('courses_relation_id',$mypdf_a)
            ->select('pdf_file_link_a')
            ->first();


        $pdf_file_link_a=$pdf_file_link_a->pdf_file_link_a;
        $arr = array();

        if(!empty($pdf_file_link_a)) {


            $arr[0] = env('APP_URL') . '/' . $pdf_file_link_a;

            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }


    }

    public function getmypdfb(Request $request)
    {
        $mypdf_b=$request->mypdf_b;

        //die($adminid);

        $pdf_file_link_b = DB::table('courses_relation')
            ->where('courses_relation_id',$mypdf_b)
            ->select('pdf_file_link_b')
            ->first();


        $pdf_file_link_b=$pdf_file_link_b->pdf_file_link_b;
        $arr = array();

        if(!empty($pdf_file_link_b)) {


            $arr[0] = env('APP_URL') . '/' . $pdf_file_link_b;

            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }


    }

    public function getTopicUtubeLink(Request $request)
    {
        $youtubetopicId=$request->youtubetopicId;

        //die($adminid);

        $topic_utube_file_link = DB::table('topic')
            ->where('topic_id',$youtubetopicId)
            ->select('topic_utube_file_link')
            ->first();


      //  dd($topic_utube_file_link);


        $topic_utube_file_link=$topic_utube_file_link->topic_utube_file_link;
        $arr = array();

        if(!empty($topic_utube_file_link)) {


            $arr[0] = $topic_utube_file_link;

            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }


    }

    public function getTopicSimpleLink(Request $request)
    {
        $simplelinktopicId=$request->simplelinktopicId;

        $topic_simple_file_link = DB::table('topic')
            ->where('topic_id',$simplelinktopicId)
            ->select('topic_simple_file_link')
            ->first();

        $topic_simple_file_link=$topic_simple_file_link->topic_simple_file_link;
        $arr = array();

        if(!empty($topic_simple_file_link)) {


            $arr[0] = $topic_simple_file_link;

            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }


    }


    public function getTopicPptFile(Request $request)
    {
        $ppttopicId=$request->ppttopicId;

        $topic_powerpoint_file_link = DB::table('topic')
            ->where('topic_id',$ppttopicId)
            ->select('topic_powerpoint_file_link')
            ->first();

        $topic_powerpoint_file_link=$topic_powerpoint_file_link->topic_powerpoint_file_link;
        $arr = array();

        if(!empty($topic_powerpoint_file_link)) {
            $arr[0] = env('APP_URL') . '/' .$topic_powerpoint_file_link;
            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();
        }
    }

    public function getTopicWordFile(Request $request)
    {
        $wordtopicId=$request->wordtopicId;

        $topic_word_file_link = DB::table('topic')
            ->where('topic_id',$wordtopicId)
            ->select('topic_word_file_link')
            ->first();

        $topic_word_file_link=$topic_word_file_link->topic_word_file_link;
        $arr = array();

        if(!empty($topic_word_file_link)) {
            $arr[0] = env('APP_URL') . '/' .$topic_word_file_link;
            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();
        }
    }


    public function getTopicPdfFile(Request $request)
    {
        $pdftopicId=$request->pdftopicId;

        $topic_pdf_file_link = DB::table('topic')
            ->where('topic_id',$pdftopicId)
            ->select('topic_pdf_file_link')
            ->first();

        $topic_pdf_file_link=$topic_pdf_file_link->topic_pdf_file_link;
        $arr = array();

        if(!empty($topic_pdf_file_link)) {
            $arr[0] = env('APP_URL') . '/' .$topic_pdf_file_link;
            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();
        }
    }



    public function getRuleUtubeLink(Request $request)
    {
        $youtuberuleId=$request->youtuberuleId;

        //die($adminid);

        $rule_utube_file_link = DB::table('scientific_term_per_topic')
            ->where('scientific_term_per_topic_id',$youtuberuleId)
            ->select('term_utube_file_link')
            ->first();


        //  dd($topic_utube_file_link);


        $rule_utube_file_link=$rule_utube_file_link->term_utube_file_link;
        $arr = array();

        if(!empty($rule_utube_file_link)) {


            $arr[0] = $rule_utube_file_link;

            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }


    }

    public function getRuleSimpleLink(Request $request)
    {
        $simplelinkruleId=$request->simplelinkruleId;

        //die($adminid);

        $rule_simple_file_link = DB::table('scientific_term_per_topic')
            ->where('scientific_term_per_topic_id',$simplelinkruleId)
            ->select('term_simple_file_link')
            ->first();


        //  dd($topic_utube_file_link);


        $rule_simple_file_link=$rule_simple_file_link->term_simple_file_link;
        $arr = array();

        if(!empty($rule_simple_file_link)) {


            $arr[0] = $rule_simple_file_link;

            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }

    }


    public function getRulePptFile(Request $request)
    {
        $pptruleId=$request->pptruleId;

        //die($adminid);

        $rule_ppt_file_link = DB::table('scientific_term_per_topic')
            ->where('scientific_term_per_topic_id',$pptruleId)
            ->select('term_ppt_file_link')
            ->first();


        //  dd($topic_utube_file_link);


        $rule_ppt_file_link=$rule_ppt_file_link->term_ppt_file_link;
        $arr = array();

        if(!empty($rule_ppt_file_link)) {


            $arr[0] = env('APP_URL') . '/' .$rule_ppt_file_link;

            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }

    }

    public function getRuleWordFile(Request $request)
    {
        $wordruleId=$request->wordruleId;

        $rule_word_file_link = DB::table('scientific_term_per_topic')
            ->where('scientific_term_per_topic_id',$wordruleId)
            ->select('term_word_file_link')
            ->first();





        $rule_word_file_link=$rule_word_file_link->term_word_file_link;
        $arr = array();

        if(!empty($rule_word_file_link)) {


            $arr[0] = env('APP_URL') . '/' .$rule_word_file_link;

            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }
    }


    public function getRulePdfFile(Request $request)
    {
        $pdfruleId=$request->pdfruleId;

        $rule_pdf_file_link = DB::table('scientific_term_per_topic')
            ->where('scientific_term_per_topic_id',$pdfruleId)
            ->select('term_pdf_file_link')
            ->first();

        $rule_pdf_file_link=$rule_pdf_file_link->term_pdf_file_link;
        $arr = array();

        if(!empty($rule_pdf_file_link)) {


            $arr[0] = env('APP_URL') . '/' .$rule_pdf_file_link;

            echo json_encode($arr);
            exit();
        }
        else
        {
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }
    }



    public function addNewTopicInCourse(Request $request)
    {
        $topic = $request->topic;

        $dataSi = $request->dataSi;
        $dataCi = $request->dataCi;

        $validator = Validator::make(Input::all(), [
            'topic' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        } else {

            DB::table('topic')->insert(
                ['topic_name' => $topic, 'schools_id' => $dataSi, 'courses_id' => $dataCi]
            );

            $arr = array();
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }


    }


    public function addNewTermInTopic(Request $request)
    {
        $term = $request->term;
       // dd($term);
        $dataRi = $request->dataRi;

       // dd($dataRi);
        $datatSi = $request->datatSi;
        $datatCi = $request->datatCi;
        $datatTi = $request->datatTi;

        $validator = Validator::make(Input::all(), [
            'dataRi' => 'required',
            'term'=>'required'

        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        } else {

            $scientific_terms_id = DB::table('scientific_terms')->insertGetId(
                array('scientific_term' => $term)
            );


            DB::table('scientific_term_per_topic')->insert(
                ['schools_id' => $datatSi, 'courses_id' => $datatCi,
                    'topic_id' => $datatTi, 'scientific_terms_id' => $scientific_terms_id,
                    'scientific_rule_id'=>$dataRi
                ]
            );

            $arr = array();
            $arr[0] = 1;
            echo json_encode($arr);
            exit();

        }


    }



}//End of Class


?>


