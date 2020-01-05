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
class RuleController extends Controller
{
    public function manageRule()
    {
        return view('Admin::mainRule.manageRule');
    }

    public function addRule(Request $request)
    {

            if ($request->isMethod('post')) {
                $rules = [
                    'scientific_rule' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                        ->withErrors($validator)
                        ->withInput();
                } else {

                    $scientific_rule = $request->input('scientific_rule');

                    DB::table('scientific_rule')->insert(
                        ['scientific_rule' => $scientific_rule
                        ]
                    );

                    return Redirect::back()->with(['code' => '200', 'message' => trans('message.NewScientificRule') . $request->input('scientific_term') . trans('message.hasbeenadded')]);
                }
            }
            return view('Admin::mainRule.addRule');
        }






    public function editRule(Request $request,$scientific_rule_id)
    {
        $scientificRule = DB::table('scientific_rule')
                        ->where('scientific_rule_id',$scientific_rule_id)
                        ->select('scientific_rule_id','scientific_rule')
                        ->get();

//
//            print_r($scientific_terms);
//            die;


        if ($request->isMethod('post')) {

            $rules = [
                'scientific_rule' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["code" => '400', 'message' => trans('message.Pleasecorrectthefollowingerrors')])
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $scientific_rule = $request->input('scientific_rule');

                $scientific_rule_id = $request->input('scientific_rule_id');

                $scientific_rule_update = DB::table('scientific_rule')
                    ->where('scientific_rule_id', '=', $scientific_rule_id)
                    ->update(['scientific_rule' => $scientific_rule]);



                return Redirect::back()->with(['code' => '200', 'message' => trans('message.ScientificRulehasbeenupdated')]);
            }
        }

        return view('Admin::mainRule.editRule')->with('scientificRule',$scientificRule);


    }

    public function ruleAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        if ($method) {
            switch ($method) {
                case 'deleteMainrule':
                    $result = DB::table('scientific_rule')
                        ->where('scientific_rule_id', '=', $request->input('dataruleId'))
                        ->delete();
                    if ($result)
                        echo json_encode(['status' => 'success', 'msg' =>trans('message.MainRulehasbeendeleted')]);
                    else
                        echo json_encode(['status' => 'error', 'msg' => 'Sorry! Main Rule has not been deleted']);
                    die;
                    break;
                case 'allRuleList':

                    DB::statement(DB::raw('set @rownum=0'));

                    $ruleList = DB::table('scientific_rule')
                             ->select('scientific_rule_id','scientific_rule', DB::raw('@rownum  := @rownum  + 1 AS rownum'));


                    return Datatables::of($ruleList)
                        ->addColumn('deleteAction', function ($ruleList) {
                            if (Auth::user()->role == 1)
                            return '<span class="tooltips" title="Delete Main Rule." data-placement="top">
                              <a href="javascript:;" data-ruleId="' . $ruleList->scientific_rule_id . '" class="btn btn-danger delete-rule" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </span>
                            <span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-rule/' . $ruleList->scientific_rule_id . '" class="btn btn-primary" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                            </span>';
                            else
                               return '<span class="tooltips" title="Edit Main Courses Detail." data-placement="top">
                              <a href="/edit-rule/' . $ruleList->scientific_rule_id . '" class="btn btn-primary" style="margin-left: 10%;">
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