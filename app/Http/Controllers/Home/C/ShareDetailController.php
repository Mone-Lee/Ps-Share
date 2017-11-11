<?php

/**
 * 分享详情页接口
 */

namespace App\Http\Controllers\Home\C;

use App\Collection;
use App\Comment;
use App\Follow;
use App\Like;
use App\Share;
use App\SharePicture;
use App\UserMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShareDetailController extends Controller
{
    /**
     * 获取分享发布者的信息
     * @param $id {String} 分享的id
     */
    public function getShareUserMsg($id)
    {
        $share = Share::find($id);
        if ($share == null) {
            return response()->json('can\'t find share');
        }
        $user = $share->user;
        $userId = $user->id;
        $userMsg = UserMessage::where('user_id', $userId)
            ->select('user_id', 'pic', 'introduction', 'sex')
            ->first();
        if ($userMsg != null) {
            $userMsg->name = $user->name;
        }

        return $userMsg;

    }

    /**
     * 获取分享的详情：发布者信息、分享详情、点赞数、收藏数、访问者是否点赞、是否收藏、是否关注
     */
    public function getShareDetail($shareId)
    {
        $shareDetail = DB::table('shares')
            ->join('user_messages', 'user_messages.user_id', '=', 'shares.user_id')
            ->join('users', 'users.id', '=', 'shares.user_id')
            ->join('share_classifications', 'share_classifications.id', '=', 'shares.share_classification_id')
            ->select(
                'share_classifications.id as sc_id',       // 分类id
                'share_classifications.name as sc_name',       // 分类名
                'shares.id as share_id',                        // 分享id
                'shares.content',                               //分享内容
                'shares.abstract',                              // 分享摘要
                'shares.created_at',                            // 发布时间
                'users.id as user_id',                          // 用户id
                'users.name as user_name',                      // 用户名称
                'user_messages.pic',                            // 用户头像
                'user_messages.introduction',                   // 用户介绍
                'user_messages.sex')// 用户性别
            ->where('users.active', 0)
            ->where('shares.status', 1)
            ->where('shares.id', $shareId)
            ->first();
        if ($shareDetail != null) {
            // 获取对应图片
            $pictures = SharePicture::where('share_id', $shareDetail->share_id)
                ->orderBy('order', 'asc')
                ->select('id', 'path', 'order')->get();

            // 获取点赞数
            $likes = Like::where('share_id', $shareDetail->share_id)->count();

            // 获取收藏数
            $collections = Collection::where('share_id', $shareDetail->share_id)->count();

            $user = Auth::user();
            $user_id = -1;
            if ($user != null) {
                $user_id = $user->id;
            }

            // 访问者是否点赞
            $statusLike = Like::where('user_id', $user_id)
                ->where('share_id', $shareDetail->share_id)
                ->select('share_id')
                ->first();

            // 访问者是否收藏
            $statusCollection = Collection::where('user_id', $user_id)
                ->where('share_id', $shareDetail->share_id)
                ->select('share_id')
                ->first();

            // 访问者是否关注
            $statusFollow = Follow::where('follower_id', $user_id)
                ->where('followed_id', $shareDetail->user_id)
                ->select('followed_id')
                ->first();

            $shareDetail->likes = $likes;
            $shareDetail->collections = $collections;
            $shareDetail->pictures = $pictures;
            $shareDetail->statusLike = $statusLike;
            $shareDetail->statusCollection = $statusCollection;
            $shareDetail->statusFollow = $statusFollow;
        }


        return response()->json($shareDetail);
    }

    /**
     * 获取分享详情页中的所有评论，有分页
     */
    public function getAllComments(Request $request)
    {
        $shareId = $request->input('shareId');
        // 获取所有评论
        $result = DB::table('comments')
            ->join('user_messages', 'user_messages.user_id', '=', 'comments.user_id')
            ->join('shares', 'shares.id', '=', 'comments.share_id')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->select(
                'users.name as user_name',                      // 用户名称
                'user_messages.pic',                            // 用户头像
                'comments.id',
                'comments.content',
                'users.id as user_id',
                'comments.share_id',
                'comments.created_at'
            )
            ->where('users.active', 0)// 评论者没有被冻结
            ->where('shares.status', 1)// 被评论的分享是发布状态
            ->whereNull('comments.pid')// 父评论
            ->where('shares.id', $shareId)
            ->orderBy('comments.created_at', 'desc')
            ->paginate(10);

        $commentList = array();
        foreach ($result as $comment) {
            $commentReplies = $this->getAllCommentReplies($request, $shareId, $comment->id);
            $item = null;
            $item['comment'] = $comment;
            $item['commentReplies'] = $commentReplies;
            array_push($commentList, $item);
        }

        $commentList = new LengthAwarePaginator($commentList, $total = $result->total(), 10);

        return $commentList;
    }

    /**
     * 获取对应评论下的所有回复
     * @param $commentId
     * @return mixed
     */
    public function getAllCommentReplies(Request $request, $shareId = null, $commentId = null)
    {

        if ($shareId == null) {
            $shareId = $request->input('shareId');
        }

        if ($commentId == null) {
            $commentId = $request->input('commentId');
        }

        // 获取分页下标
        $page = $request->input('page');
        if ($page == null) {
            $page = 1;
        }
        // 获取每页的页数
        $paginate = 5;

        $commentRepliesLeft = DB::table('comments')
            ->leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('user_messages', 'user_messages.user_id', '=', 'comments.user_id')
            ->leftJoin('users as users_replied', 'users_replied.id', '=', 'comments.usered_id')
            ->select(
                'comments.id as comment_replies_id',
                'users.id as user_id',
                'users.name as user_name',
                'user_messages.pic',
                'comments.content',
                'comments.created_at',
                'comments.usered_id as comment_replied_user_id',
                'users_replied.name as users_replied_name',
                'comments.share_id',
                'comments.pid',
                'comments.comment_id'
            )
            ->where('users.active', 0)
            ->where('comments.comment_id', $commentId)
            ->whereNotNull('comments.pid')
            ->where('comments.share_id', $shareId)
            ->orderBy('created_at', 'asc');

        $commentReplies = DB::table('comments')
            ->leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('user_messages', 'user_messages.user_id', '=', 'comments.user_id')
            ->leftJoin('users as users_replied', 'users_replied.id', '=', 'comments.usered_id')
            ->select(
                'comments.id as comment_replies_id',
                'users.id as user_id',
                'users.name as user_name',
                'user_messages.pic',
                'comments.content',
                'comments.created_at',
                'comments.usered_id as comment_replied_user_id',
                'users_replied.name as users_replied_name',
                'comments.share_id',
                'comments.pid',
                'comments.comment_id'
            )
            ->union($commentRepliesLeft)
            ->where('users.active', 0)
            ->where('comments.comment_id', $commentId)
            ->whereNotNull('comments.pid')
            ->where('comments.share_id', $shareId)
            ->orderBy('created_at', 'asc')
            ->get();

        $commentRepliesTmp = array_slice($commentReplies->toArray(), $paginate * ($page - 1), $paginate);

        $commentReplies = new LengthAwarePaginator($commentRepliesTmp, sizeof($commentReplies), $paginate);

        return $commentReplies;
    }


}
