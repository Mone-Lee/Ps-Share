<?php

/**
 * 用户行为接口
 */

namespace App\Http\Controllers\Home\C;

use App\CommentReport;
use App\ReportClassification;
use App\ShareReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * 举报分享
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportShare(Request $request)
    {
        $this->validate($request, [
            'share_id' => 'required',
            'report_classification_id' => 'required'
        ]);

        $user = Auth::user();
        if($user == null){
            return response()->json('false');
        }
        // 举报者id
        $userId = $user->id;
        // 被举报分享id
        $shareId = $request->input('share_id');
        // 举报分类id
        $reportClassificationId = $request->input('report_classification_id');
        // 举报内容
        $content = $request->input('content');

        $reportClassification = ReportClassification::find($reportClassificationId);
        if($reportClassification == null){
            return response()->json('can\'t find report classification!');
        }

        $report = ShareReport::where('user_id', $userId)
            ->where('share_id', $shareId)
            ->first();
        if($report != null){
            return response()->json('already report!');
        }

        $shareReport = new ShareReport();
        $shareReport->user_id = $userId;
        $shareReport->share_id = $shareId;
        $shareReport->report_classification_id = $reportClassificationId;
        if($content != null){
            $shareReport->content = $content;
        }
        $shareReport->save();

        return response()->json('true');

    }

    /**
     * 举报评论
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportComment(Request $request)
    {
        $this->validate($request, [
            'comment_id' => 'required',
            'report_classification_id' => 'required'
        ]);

        $user = Auth::user();
        if($user == null){
            return response()->json('false');
        }
        // 举报者id
        $userId = $user->id;
        // 被举报评论id
        $commentId = $request->input('comment_id');
        // 举报分类id
        $reportClassificationId = $request->input('report_classification_id');
        // 举报内容
        $content = $request->input('content');

        $reportClassification = ReportClassification::find($reportClassificationId);
        if($reportClassification == null){
            return response()->json('can\'t find report classification!');
        }

        $report = CommentReport::where('user_id', $userId)
            ->where('comment_id', $commentId)
            ->first();
        if($report != null){
            return response()->json('already report!');
        }

        $commentReport = new CommentReport();
        $commentReport->user_id = $userId;
        $commentReport->comment_id = $commentId;
        $commentReport->report_classification_id = $reportClassificationId;
        if($content != null){
            $commentReport->content = $content;
        }
        $commentReport->save();

        return response()->json('true');

    }
}
