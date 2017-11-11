<?php

/**
 * 举报分享接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Share;
use App\ShareReport;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShareReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!Auth::user()->can('report-share-index')){
            return response()->json('false');
        }

        $groups = ShareReport::selectRaw('count(*) as total, share_id')
            ->groupBy('share_reports.share_id')
            ->paginate(10);

        $reportsList = array();
        foreach ($groups as $group) {
            $report = DB::table('share_reports')
                ->join('users', 'users.id', '=', 'share_reports.user_id')
                ->join('shares', 'shares.id', '=', 'share_reports.share_id')
                ->join('report_classifications', 'report_classifications.id', '=', 'share_reports.report_classification_id')
                ->select(
                    'share_reports.id as share_report_id',          // 举报id
                    'users.id as user_id',          // 举报者id
                    'users.name as user_name',      // 举报者名字
                    'shares.id as share_id',      // 分享id
                    'shares.abstract as share_abstract',      // 分享摘要
                    'shares.user_id as usered_id',      // 被举报者id
                    'report_classifications.name as report_classification_name',      // 举报分类名
                    'share_reports.content as report_content',      // 举报内容
                    'share_reports.status as report_status'      // 举报状态
                )
                ->where('share_reports.share_id', $group->share_id)
                ->first();
            $user = User::where('id', $report->usered_id)->first();
            if ($user != null) {
                $report->usered_name = $user->name;
            }
            $report->total = $group->total;
            array_push($reportsList, $report);
        }

        $reportsList = new LengthAwarePaginator($reportsList, $groups->total(), 10);

        return $reportsList;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if(!Auth::user()->can('report-share-more')){
            return response()->json('false');
        }

        $reports = DB::table('share_reports')
            ->join('users', 'users.id', '=', 'share_reports.user_id')
            ->join('shares', 'shares.id', '=', 'share_reports.share_id')
            ->join('report_classifications', 'report_classifications.id', '=', 'share_reports.report_classification_id')
            ->select(
                'share_reports.id as share_report_id',          // 举报id
                'users.id as user_id',          // 举报者id
                'users.name as user_name',      // 举报者名字
                'shares.id as share_id',      // 分享id
                'shares.abstract as share_abstract',      // 分享摘要
                'shares.user_id as usered_id',      // 被举报者id
                'report_classifications.name as report_classification_name',      // 举报分类名
                'share_reports.content as report_content',      // 举报内容
                'share_reports.status as report_status'      // 举报状态
            )
            ->where('share_reports.share_id', $id)
            ->paginate(15);
        $reportsList = array();
        foreach ($reports as $report) {
            $user = User::where('id', $report->usered_id)->first();
            if ($user != null) {
                $report->usered_name = $user->name;
            }
            array_push($reportsList, $report);
        }

        $reportsList = new LengthAwarePaginator($reportsList, $total = $reports->total(), 15);

        return $reportsList;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $reportId)
    {

        if(!Auth::user()->can('report-share-delete')){
            return response()->json('false');
        }

        $this->validate($request, [
            'shareId' => 'required'
        ]);

        $shareId = $request->input('shareId');

        // 删除分享
        Share::destroy($shareId);
        // 删除分享举报
        ShareReport::where('share_id', $shareId)->delete();

        return response()->json('true');

    }

    /**
     * 屏蔽或解除屏蔽
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function triggle(Request $request)
    {
        if(!Auth::user()->can('report-share-triggle')){
            return response()->json('false');
        }

        $this->validate($request, [
            'reportId' => 'required',
            'shareId' => 'required'
        ]);

        $reportId = $request->input('reportId');
        $shareId = $request->input('shareId');
        
        $share = Share::find($shareId);
        $share->status = $share->status == 3 ? 1 : 3;
        $share->save();
        
        $report = ShareReport::find($reportId);
        $report->status = $report->status == 0 ? 1 : 0;
        $report->save();
        
        return response()->json($report->status);
    }
}
