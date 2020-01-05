<?php

namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Redirect;
use View;

/**
 * Class TeacherController
 */
class UploadController extends Controller
{
    public function uploadTopicYouTube(Request $request)
    {
        $utube_file=$request->utube_file;

        $utube_link=$request->utube_link;
        $CourseTopicId = $request->input('CourseTopicId');

        $validator = Validator::make($request->all(), [
            'utube_link' => ['required', 'regex:^(http(s)??\:\/\/)?(www\.)?((youtube\.com\/watch\?v=)|(youtu.be\/))([a-zA-Z0-9\-_])+$^']

        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        } else {
            DB::table('topic')
                ->where('topic_id', $CourseTopicId)
                ->update(['topic_utube_file_link' => $utube_link]);

            $topic_details = DB::table('topic')
                ->where('topic_id',$CourseTopicId)
                ->first();

            echo json_encode($topic_details);
            die();

          }

    }


    public function uploadTopicLink(Request $request)
    {
        $CourseTopicId = $request->input('CourseTopicId');

        $simpleLink_file = $request->input('simpleLink_file');

        $topic_simple_link = $request->input('topic_simple_link');

        $validator = Validator::make($request->all(), [
            'topic_simple_link' => ['required', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/']

        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        }  else {

            DB::table('topic')
                ->where('topic_id', $CourseTopicId)
                ->update(['topic_simple_file_link' => $topic_simple_link]);

            $topic_details = DB::table('topic')
                ->where('topic_id',$CourseTopicId)
                ->first();


            echo json_encode($topic_details);
            die();
        }
    }



    public function uploadTopicPpt(Request $request)
    {
        $CourseTopicId = $request->input('CourseTopicId');

        $fileType = $request->input('fileType');
        $file = $request->file('upload_file');

            if ($file)
                $fileExtension = strtolower($file->getClientOriginalExtension());
            else
                $fileExtension = '';

            $inputData = [
                'upload_file' => $fileExtension,
            ];

            if ($fileType == 'topic_ppt')
                $rules = [
                    'upload_file' => 'required|in:pptx,',
                ];



            $validator = Validator::make($inputData, $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        } else {

                $fileName = 'course-topic-' . $fileType . '-' . $CourseTopicId . '.' . $fileExtension;

                $file->move('uploads/courseTopicFiles', $fileName);
                $fileUrl = 'uploads/courseTopicFiles/' . $fileName;

                $data = array();

                if ($fileType == 'topic_ppt')
                    $data['topic_powerpoint_file_link'] = $fileUrl;

                DB::table('topic')
                    ->where('topic_id', '=', $CourseTopicId)
                    ->update($data);

            $topic_details = DB::table('topic')
                ->where('topic_id',$CourseTopicId)
                ->first();


            echo json_encode($topic_details);
            die();
        }
    }


    public function uploadTopicWord(Request $request)
    {
        $CourseTopicId = $request->input('CourseTopicId');

        $fileType = $request->input('fileType');
        $file = $request->file('upload_file');

        if ($file)
            $fileExtension = strtolower($file->getClientOriginalExtension());
        else
            $fileExtension = '';

        $inputData = [
            'upload_file' => $fileExtension,
        ];

             if ($fileType == 'topic_msword')
                $rules = [
                    'upload_file' => 'required|in:docx,doc,',
                ];

        $validator = Validator::make($inputData, $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        } else {

            $fileName = 'course-topic-' . $fileType . '-' . $CourseTopicId . '.' . $fileExtension;

            $file->move('uploads/courseTopicFiles', $fileName);
            $fileUrl = 'uploads/courseTopicFiles/' . $fileName;

            $data = array();

              if ($fileType == 'topic_msword')
                    $data['topic_word_file_link'] = $fileUrl;

            DB::table('topic')
                ->where('topic_id', '=', $CourseTopicId)
                ->update($data);

            $topic_details = DB::table('topic')
                ->where('topic_id',$CourseTopicId)
                ->first();


            echo json_encode($topic_details);
            die();
        }
    }


    public function uploadTopicPdf(Request $request)
    {
        $CourseTopicId = $request->input('CourseTopicId');

        $fileType = $request->input('fileType');
        $file = $request->file('upload_file');

        if ($file)
            $fileExtension = strtolower($file->getClientOriginalExtension());
        else
            $fileExtension = '';

        $inputData = [
            'upload_file' => $fileExtension,
        ];

             if ($fileType == 'topic_pdf')
                $rules = [
                    'upload_file' => 'required|in:pdf,',
                ];

        $validator = Validator::make($inputData, $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        } else {

            $fileName = 'course-topic-' . $fileType . '-' . $CourseTopicId . '.' . $fileExtension;

            $file->move('uploads/courseTopicFiles', $fileName);
            $fileUrl = 'uploads/courseTopicFiles/' . $fileName;

            $data = array();

              if ($fileType == 'topic_pdf')
                    $data['topic_pdf_file_link'] = $fileUrl;

            DB::table('topic')
                ->where('topic_id', '=', $CourseTopicId)
                ->update($data);

            $topic_details = DB::table('topic')
                ->where('topic_id',$CourseTopicId)
                ->first();


            echo json_encode($topic_details);
            die();
        }
    }


//  Term File Upload

    public function uploadTermYouTube(Request $request)
    {
        $TopicTermRuleId = $request->input('TopicTermRuleId');
        $term_utube_file = $request->input('term_utube_file');
        $term_utube_link = $request->input('term_utube_link');




        $validator = Validator::make($request->all(), [
            'term_utube_link' => ['required', 'regex:^(http(s)??\:\/\/)?(www\.)?((youtube\.com\/watch\?v=)|(youtu.be\/))([a-zA-Z0-9\-_])+$^']

        ]);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        } else {
            DB::table('scientific_term_per_topic')
                ->where('scientific_term_per_topic_id', $TopicTermRuleId)
                ->update(['term_utube_file_link' => $term_utube_link]);

            $term_details = DB::table('scientific_term_per_topic')
                ->where('scientific_term_per_topic_id',$TopicTermRuleId)
                ->first();

            echo json_encode($term_details);
            die();

        }

    }


    public function uploadTermLink(Request $request)
    {
        $TopicTermRuleId = $request->input('TopicTermRuleId');
        $term_simpleLink_file = $request->input('term_simpleLink_file');
        $term_simple_link = $request->input('term_simple_link');

        $validator = Validator::make($request->all(), [
            'term_simple_link' => ['required', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/']

        ]);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        }  else {

            DB::table('scientific_term_per_topic')
                ->where('scientific_term_per_topic_id', $TopicTermRuleId)
                ->update(['term_utube_file_link' => $term_simple_link]);

            $term_details = DB::table('scientific_term_per_topic')
                ->where('scientific_term_per_topic_id',$TopicTermRuleId)
                ->first();

            echo json_encode($term_details);
            die();
        }
    }



    public function uploadTermPpt(Request $request)
    {
        $TopicTermRuleId = $request->input('TopicTermRuleId');

        $fileType = $request->input('fileType');
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



        $validator = Validator::make($inputData, $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        } else {

            $fileName = 'course-topic-' . $fileType . '-' . $TopicTermRuleId . '.' . $fileExtension;

            $file->move('uploads/topicTermRuleFiles', $fileName);
            $fileUrl = 'uploads/topicTermRuleFiles/' . $fileName;




            DB::table('scientific_term_per_topic')
                ->where('scientific_term_per_topic_id', $TopicTermRuleId)
                ->update(['term_ppt_file_link' => $fileUrl]);

            $term_details = DB::table('scientific_term_per_topic')
                ->where('scientific_term_per_topic_id',$TopicTermRuleId)
                ->first();

            echo json_encode($term_details);
            die();
        }
    }


    public function uploadTermWord(Request $request)
    {
        $TopicTermRuleId = $request->input('TopicTermRuleId');

        $fileType = $request->input('fileType');
        $file = $request->file('upload_file');

        if ($file)
            $fileExtension = strtolower($file->getClientOriginalExtension());
        else
            $fileExtension = '';

        $inputData = [
            'upload_file' => $fileExtension,
        ];

     if ($fileType == 'term_msword')
        $rules = [
            'upload_file' => 'required|in:docx,doc,',
        ];


        $validator = Validator::make($inputData, $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        } else {

            $fileName = 'course-topic-' . $fileType . '-' . $TopicTermRuleId . '.' . $fileExtension;

            $file->move('uploads/topicTermRuleFiles', $fileName);
            $fileUrl = 'uploads/topicTermRuleFiles/' . $fileName;




            DB::table('scientific_term_per_topic')
                ->where('scientific_term_per_topic_id', $TopicTermRuleId)
                ->update(['term_word_file_link' => $fileUrl]);

            $term_details = DB::table('scientific_rule')
                ->where('scientific_term_per_topic_id',$TopicTermRuleId)
                ->first();

            echo json_encode($term_details);
            die();
        }
    }


    public function uploadTermPdf(Request $request)
    {
        $TopicTermRuleId = $request->input('TopicTermRuleId');

        $fileType = $request->input('fileType');
        $file = $request->file('upload_file');

        if ($file)
            $fileExtension = strtolower($file->getClientOriginalExtension());
        else
            $fileExtension = '';

        $inputData = [
            'upload_file' => $fileExtension,
        ];

       if ($fileType == 'term_pdf')
        $rules = [
            'upload_file' => 'required|in:pdf,',
        ];

        $validator = Validator::make($inputData, $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        } else {

            $fileName = 'course-topic-' . $fileType . '-' . $TopicTermRuleId . '.' . $fileExtension;

            $file->move('uploads/topicTermRuleFiles', $fileName);
            $fileUrl ='uploads/topicTermRuleFiles/' . $fileName;


           // dd($fileUrl);

           // dd($TopicTermRuleId);


            DB::table('scientific_term_per_topic')
                ->where('scientific_term_per_topic_id', $TopicTermRuleId)
                ->update(['term_pdf_file_link' => $fileUrl]);

            $term_details = DB::table('scientific_rule')
                ->where('scientific_term_per_topic_id',$TopicTermRuleId)
                ->first();

            echo json_encode($term_details);
            die();
        }
    }



}//End of Class