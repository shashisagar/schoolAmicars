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
use DISTINCT;


/**
 * Class TeacherController
 */
class TermController extends Controller
{
    public function manageTerm()
    {
        return view('Admin::mainTerm.manageTerm');
    }

    public function addTerm(Request $request)
    {
        if(Auth::user()->role == 1) {
            if ($request->isMethod('post')) {
                $rules = [
                    'school' => 'required',
//                    'teaching_stage' => 'required',
                    'course_name' => 'required',
                    'topic_name' => 'required',
                    'scientific_rule' => 'required',
                    'scientific_term' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' =>  trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $school = $request->input('school');

//                    $teaching_stage = $request->input('teaching_stage');

                    $course_name = $request->input('course_name');

                    $topic_name = $request->input('topic_name');

                    $scientific_rule = $request->input('scientific_rule');


                 //   dd($scientific_rule);



                    $scientific_term = $request->input('scientific_term');


                    $scientific_terms_id = DB::table('scientific_terms')->insertGetId(
                        array('scientific_term' => $scientific_term)
                    );


                    DB::table('scientific_term_per_topic')->insert(
                        ['schools_id' => $school, 'courses_id' => $course_name,
                            'topic_id' => $topic_name, 'scientific_terms_id' => $scientific_terms_id,
                            'scientific_rule_id'=>$scientific_rule
                            ]
                    );

                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NewScientificTerm') . $request->input('scientific_term') . trans('message.hasbeenadded')]);
                }
            }

            $schoolList = DB::table('schools')
                ->select('schools_id', 'name')
                ->get();

//            $teaching_stage = DB::table('teaching_stage')
//                ->select('teaching_stage_id', 'name')
//                ->get();



            $allCourses = DB::table('courses')
                ->select('courses_id', 'course_name')
                ->get();


            $topicList = DB::table('topic')
                ->select('topic_id', 'topic_name')
                ->get();


            $ruleList = DB::table('scientific_rule')
                ->select('scientific_rule_id', 'scientific_rule')
                ->get();


            return view('Admin::mainTerm.addTerm', ['schoolList' => $schoolList, 'allCourses' => $allCourses,  'topicList' => $topicList,'ruleList'=>$ruleList]);
        }
        else
        {
            $school = Auth::user()->schools_id;

            if ($request->isMethod('post')) {
                $rules = [
//                    'teaching_stage' => 'required',
                    'course_name' => 'required',
                    'topic_name' => 'required',
                    'scientific_rule' => 'required',
                    'scientific_term' => 'required',

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

                    $scientific_term = $request->input('scientific_term');
                    $scientific_rule = $request->input('scientific_rule');




                    $scientific_terms_id = DB::table('scientific_terms')->insertGetId(
                        array('scientific_term' => $scientific_term)
                    );




                    DB::table('scientific_term_per_topic')->insert(
                        ['schools_id' => $school, 'courses_id' => $course_name,
                            'topic_id' => $topic_name, 'scientific_terms_id' => $scientific_terms_id,'scientific_rule_id'=>$scientific_rule
                            ]
                    );

                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NewScientificTerm') . $request->input('scientific_term') . trans('message.hasbeenadded')]);
                }
            }


//            $teaching_stage = DB::table('teaching_stage')
//                ->select('teaching_stage_id', 'name')
//                ->get();

            $allCourses = DB::table('courses')
                ->where('schools_id',$school)
                ->select('courses_id', 'course_name')
                ->get();


            $ruleList = DB::table('scientific_rule')
                ->select('scientific_rule_id', 'scientific_rule')
                ->get();

            return view('Admin::mainTerm.addTerm', ['allCourses' => $allCourses,'ruleList'=>$ruleList]);

        }
    }



    public function editTerm(Request $request,$scientific_terms_id)
    {
        $scientificTerm = DB::table('scientific_terms')
                        ->where('scientific_terms_id',$scientific_terms_id)
                        ->select('scientific_terms_id','scientific_term')
                        ->get();

//
//            print_r($scientific_terms);
//            die;


        if ($request->isMethod('post')) {

            $rules = [
                'scientific_term' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $scientific_term = $request->input('scientific_term');


                $scientific_terms_id = $request->input('scientific_term_id');

                $scientific_terms_update = DB::table('scientific_terms')
                    ->where('scientific_terms_id', '=', $scientific_terms_id)
                    ->update(['scientific_term' => $scientific_term]);

//                $scientific_rule_update = DB::table('scientific_rule')
//                    ->where('scientific_rule_id', '=', $scientific_rule_id)
//                    ->update(['scientific_rule' => $scientific_rule]);


                return Redirect::back()->with(['code' => '200', 'message' => trans('message.ScientificTermshasbeenupdated.')]);
            }
        }

        return view('Admin::mainTerm.editTerm')->with('scientificTerm',$scientificTerm);


    }

    public function termAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        if ($method) {
            switch ($method) {
                case 'deleteMainterm':
                    $result = DB::table('scientific_terms')
                        ->where('scientific_terms_id', '=', $request->input('datatermId'))
                        ->delete();

                    $result1 = DB::table('scientific_term_per_topic')
                        ->where('scientific_terms_id', '=', $request->input('datatermId'))
                        ->delete();

                    if ($result && $result1)
                        echo json_encode(['status' => 'success', 'msg' => trans('message.MainTermhasbeendeleted')]);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! Main Term has not been deleted']);
                    die;
                    break;
                case 'allTermList':
                    DB::statement(DB::raw('set @rownum=0'));
                    if (Auth::user()->role == 1)
                    $termList = DB::table('scientific_terms')
                        ->join('scientific_term_per_topic', 'scientific_term_per_topic.scientific_terms_id', '=', 'scientific_terms.scientific_terms_id')
                        ->join('scientific_rule', 'scientific_term_per_topic.scientific_rule_id', '=', 'scientific_rule.scientific_rule_id')

                        ->join('schools', 'scientific_term_per_topic.schools_id', '=', 'schools.schools_id')
                        ->join('courses', 'courses.courses_id', '=', 'scientific_term_per_topic.courses_id')
                        ->join('topic', 'topic.topic_id', '=', 'scientific_term_per_topic.topic_id')
//                        ->join('teaching_stage', 'teaching_stage.teaching_stage_id', '=', 'scientific_term_per_topic.teaching_stage_id')
                        ->select ('scientific_terms.scientific_terms_id','scientific_terms.scientific_term','scientific_rule.scientific_rule', 'topic.topic_name','courses.course_name','schools.name as schoolName',
                            DB::raw('@rownum  := @rownum  + 1 AS rownum'));
                    else
                        $termList = DB::table('scientific_terms')
                            ->join('scientific_term_per_topic', 'scientific_term_per_topic.scientific_terms_id', '=', 'scientific_terms.scientific_terms_id')
                            ->join('schools', 'scientific_term_per_topic.schools_id', '=', 'schools.schools_id')
                            ->join('scientific_rule', 'scientific_term_per_topic.scientific_rule_id', '=', 'scientific_rule.scientific_rule_id')

                            ->join('courses', 'courses.courses_id', '=', 'scientific_term_per_topic.courses_id')
                            ->join('topic', 'topic.topic_id', '=', 'scientific_term_per_topic.topic_id')
//                            ->join('teaching_stage', 'teaching_stage.teaching_stage_id', '=', 'scientific_term_per_topic.teaching_stage_id')
                            ->where('scientific_term_per_topic.schools_id', '=', Auth::user()->schools_id)
                            ->select('scientific_terms.scientific_terms_id','scientific_terms.scientific_term','scientific_rule.scientific_rule', 'topic.topic_name','courses.course_name','schools.name as schoolName',
                                 DB::raw('@rownum  := @rownum  + 1 AS rownum'));

                    return Datatables::of($termList)
                        ->addColumn('deleteAction', function ($termList) {
                            if (Auth::user()->role == 1)
                            return '<span class="tooltips" title="Delete Main Term." data-placement="top">
                              <a href="javascript:;" data-termId="' . $termList->scientific_terms_id . '" class="btn btn-danger delete-term" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-term/' . $termList->scientific_terms_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                            else
                               return '<span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-term/' . $termList->scientific_terms_id . '" class="btn btn-primary" style="margin-left: 10%;">
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