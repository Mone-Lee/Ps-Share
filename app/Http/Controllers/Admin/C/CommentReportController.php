<?php

/**
 * 举报评论接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Comment;
use App\CommentReport;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!Auth::user()->can('report-comment-index')){
            return response()->json('false');
        }

        $groups = CommentReport::selectRaw('count(*) as total, comment_id')
            ->groupBy('comment_reports.comment_id')
            ->paginate(10);

        $reportsList = array();
        foreach ($groups as $group) {
            $report = DB::table('comment_reports')
                ->join('users', 'users.id', '=', 'comment_reports.user_id')
                ->join('comments', 'comments.id', '=', 'comment_reports.comment_id')
                ->join('report_classifications', 'report_classifications.id', '=', 'comment_reports.report_classification_id')
                ->select(
                    'comment_reports.id as comment_report_id',          // 举报id
                    'users.id as user_id',          // 举报者id
                    'users.name as user_name',      // 举报者名字
                    'comments.id as comment_id',      // 评论id
                    'comments.content as comment_content',      // 评论内容
                    'comments.user_id as usered_id',      // 被举报者id
                    'report_classifications.name as report_classification_name',      // 举报分类名
                    'comment_reports.content as report_content',      // 举报内容
                    'comment_reports.status as report_status'      // 举报状态
                )
                ->where('comment_reports.comment_id', $group->comment_id)
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if(!Auth::user()->can('report-comment-more')){
            return response()->json('false');
        }

        $reports = DB::table('comment_reports')
            ->join('users', 'users.id', '=', 'comment_reports.user_id')
            ->join('comments', 'comments.id', '=', 'comment_reports.comment_id')
            ->join('report_classifications', 'report_classifications.id', '=', 'comment_reports.report_classification_id')
            ->select(
                'comment_reports.id as comment_report_id',          // 举报id
                'users.id as user_id',          // 举报者id
                'users.name as user_name',      // 举报者名字
                'comments.id as comment_id',      // 评论id
                'comments.content as comment_content',      // 评论内容
                'comments.user_id as usered_id',      // 被举报者id
                'report_classifications.name as report_classification_name',      // 举报分类名
                'comment_reports.content as report_content',      // 举报内容
                'comment_reports.status as report_status'      // 举报状态
            )
            ->where('comment_reports.comment_id', $id)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->can('report-comment-delete')){
            return response()->json('false');
        }

        $this->validate($request, [
            'commentId' => 'required'
        ]);

        $commentId = $request->input('commentId');

        // 删除评论
        Comment::destroy($commentId);
        // 删除评论举报
        CommentReport::where('comment_id', $commentId)->delete();

        return response()->json('true');
    }

    /**
     * 忽略或解除忽略
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function triggle(Request $request)
    {

        if(!Auth::user()->can('report-comment-triggle')){
            return response()->json('false');
        }

        $this->validate($request, [
            'reportId' => 'required',
        ]);

        $reportId = $request->input('reportId');

        $report = CommentReport::find($reportId);
        $report->status = $report->status == 0 ? 1 : 0;
        $report->save();

        return response()->json($report->status);
    }
}
