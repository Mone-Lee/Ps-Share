<?php

/**
 * 举报分类接口
 */

namespace App\Http\Controllers\Admin\C;

use App\CommentReport;
use App\ReportClassification;
use App\ShareReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::user()->can('reportClassification-add')){
            return response()->json('false');
        }

        $this->validate($request, [
            'name' => 'required|max:20|unique:report_classifications,name'
        ]);

        $name = $request->input('name');

        $reportClassification = new ReportClassification();
        $reportClassification->name = $name;
        $reportClassification->save();

        return $reportClassification->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(!Auth::user()->can('reportClassification-edit')){
            return response()->json('false');
        }

        $this->validate($request, [
            'name' => 'required|max:20'
        ]);

        $name = $request->input('name');

        $old = ReportClassification::find($id);

        if($old->name == $name){
            return response()->json('nothing change');
        }

        $theSame = ReportClassification::where('name', $name)->first();
        if($theSame != null){
            return response()->json('the name already exist!');
        }

        $old->name = $name;
        $old->save();

        return response()->json('true');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can('reportClassification-delete')){
            return response()->json('false');
        }

        // 判断分类下是否存在举报
        $commentReport = CommentReport::where('report_classification_id', $id)
            ->get();
        $shareReport = ShareReport::where('report_classification_id', $id)
            ->get();
        if(sizeof($commentReport) != 0 || sizeof($shareReport) != 0){
            return response()->json('can\'t delete!');
        }

        $result = ReportClassification::destroy($id);

        if ($result > 0) {
            return response()->json('true');
        } else {
            return response()->json('false');
        }
    }

    /**
     * 批量删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function batchDestroy(Request $request)
    {
        if(!Auth::user()->can('reportClassification-batchDelete')){
            return response()->json('false');
        }

        $ids = $request->all();
        // 判断分类下是否存在举报
        $commentReport = CommentReport::whereIn('report_classification_id', $ids)
            ->get();
        $shareReport = ShareReport::whereIn('report_classification_id', $ids)
            ->get();
        if(sizeof($commentReport) != 0 || sizeof($shareReport) != 0){
            return response()->json('can\'t delete!');
        }

        

        $result =  ReportClassification::destroy($ids);

        $reportClassfications = ReportClassification::select('id', 'name')
            ->orderBy('created_at', 'desc')
            ->get();

        $return = [];
        $return['result'] = $result;
        $return['reportClassfications'] = $reportClassfications;

        return response()->json($return);
    }
}
