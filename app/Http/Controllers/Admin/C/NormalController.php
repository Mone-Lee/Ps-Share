<?php

/**
 * 存放不属于某一特定页面的接口
 */

namespace App\Http\Controllers\Admin\C;

use App\ShareClassification;
use App\SharePicture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NormalController extends Controller
{
    /**
     * 获取用户所有收到的评论和回复
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAllComments(Request $request)
    {
        $user = Auth::user();
        if ($user == null) {
            return response()->json('false');
        }

        // 获取用户所有分享下的所有评论
        $commentsLeft = DB::table('comments')
            ->join('shares', 'shares.id', '=', 'comments.share_id')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->join('users as users_reply', 'users_reply.id', '=', 'comments.usered_id')
            ->join('user_messages', 'user_messages.user_id', '=', 'comments.user_id')
            ->join('user_messages as user_messages_reply', 'user_messages_reply.user_id', '=', 'comments.usered_id')
            ->leftJoin('comments as comment_replied', 'comment_replied.id', '=', 'comments.pid')
            ->select(
                'comments.id',// 评论id
                'comments.pid',// 评论pid
                'comments.content', // 评论内容
                'comments.created_at',// 评论时间

                'comment_replied.id as comment_replied_id',// 被评论的评论id
                'comment_replied.content as comment_replied_content', // 被评论的评论内容
                'comment_replied.created_at as comment_replied_created_at',// 被评论的评论时间

                'comments.user_id',// 评论者id
                'users.name', // 评论者名称
                'user_messages.pic', // 评论者头像

                'comments.usered_id',// 被评论者id
                'users_reply.name as reply_user_name', // 被评论者名称
                'user_messages_reply.pic as reply_user_pic', // 被评论者头像

                'comments.share_id', // 分享id
                'shares.abstract as share_abstract'// 分享摘要
            )
            ->where('shares.user_id', $user->id)
            ->whereNull('comments.pid');

        // 获取用户所有分享下的所有评论回复
        $commentsMiddle = DB::table('comments')
            ->join('shares', 'shares.id', '=', 'comments.share_id')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->join('users as users_reply', 'users_reply.id', '=', 'comments.usered_id')
            ->join('user_messages', 'user_messages.user_id', '=', 'comments.user_id')
            ->join('user_messages as user_messages_reply', 'user_messages_reply.user_id', '=', 'comments.usered_id')
            ->leftJoin('comments as comment_replied', 'comment_replied.id', '=', 'comments.pid')
            ->select(
                'comments.id',// 评论id
                'comments.pid',// 评论pid
                'comments.content', // 评论内容
                'comments.created_at',// 评论时间

                'comment_replied.id as comment_replied_id',// 被评论的评论id
                'comment_replied.content as comment_replied_content', // 被评论的评论内容
                'comment_replied.created_at as comment_replied_created_at',// 被评论的评论时间

                'comments.user_id',// 评论者id
                'users.name', // 评论者名称
                'user_messages.pic', // 评论者头像

                'comments.usered_id',// 被评论者id
                'users_reply.name as reply_user_name', // 被评论者名称
                'user_messages_reply.pic as reply_user_pic', // 被评论者头像

                'comments.share_id', // 分享id
                'shares.abstract as share_abstract'// 分享摘要
            )
            ->where('shares.user_id', $user->id)
            ->whereNotNull('comments.pid');

        // 获取用户在其他分享下的所有回复
        $comments = DB::table('comments')
            ->join('shares', 'shares.id', '=', 'comments.share_id')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->join('users as users_reply', 'users_reply.id', '=', 'comments.usered_id')
            ->join('user_messages', 'user_messages.user_id', '=', 'comments.user_id')
            ->join('user_messages as user_messages_reply', 'user_messages_reply.user_id', '=', 'comments.usered_id')
            ->leftJoin('comments as comment_replied', 'comment_replied.id', '=', 'comments.pid')
            ->select(
                'comments.id',// 评论id
                'comments.pid',// 评论pid
                'comments.content', // 评论内容
                'comments.created_at',// 评论时间

                'comment_replied.id as comment_replied_id',// 被评论的评论id
                'comment_replied.content as comment_replied_content', // 被评论的评论内容
                'comment_replied.created_at as comment_replied_created_at',// 被评论的评论时间

                'comments.user_id',// 评论者id
                'users.name', // 评论者名称
                'user_messages.pic', // 评论者头像

                'comments.usered_id',// 被评论者id
                'users_reply.name as reply_user_name', // 被评论者名称
                'user_messages_reply.pic as reply_user_pic', // 被评论者头像

                'comments.share_id', // 分享id
                'shares.abstract as share_abstract'// 分享摘要
            )
            ->where('shares.user_id', '<>', $user->id)
            ->where('shares.status', 1)
            ->where('comments.usered_id', $user->id)
            ->whereNotNull('comments.pid')
            ->union($commentsLeft)
            ->union($commentsMiddle)
            ->orderBy('created_at', 'desc')
            ->get();

        // 获取分页下标
        $page = $request->input('page');
        if ($page == null) {
            $page = 1;
        }
        // 获取每页的页数
//        $paginate = config('app.page_size');
        $paginate = 10;

        $result = array_slice($comments->toArray(), $paginate * ($page - 1), $paginate);

        $result = new LengthAwarePaginator($result, sizeof($comments), $paginate);

        return $result;
    }

    /**
     * 获取用户所有收到的赞
     * @return mixed
     */
    public function getAllLikes()
    {
        $myLikes = DB::table('likes')
            ->join('users', 'users.id', '=', 'likes.user_id')
            ->join('shares', 'shares.id', '=', 'likes.share_id')
            ->select(
                'users.id as user_id',  //点赞者id
                'users.name as user_name',  // 点赞者名称
                'shares.id as share_id',    // 被点赞的分享id
                'shares.abstract as share_abstract',    //被点赞的分享的摘要
                'shares.content as share_content',    //被点赞的分享的内容
                'likes.created_at as like_created_at'    //点赞时间
            )
            ->where('shares.user_id', Auth::user()->id)
            ->orderBy('likes.created_at', 'desc')
            ->paginate(10);

        return $myLikes;
    }

    /**
     * 获取所有点过赞的分享
     * @return LengthAwarePaginator|array
     */
    public function getAllLikedShare()
    {
        $shares = DB::table('shares')
            ->join('likes', 'likes.share_id', '=', 'shares.id')
            ->join('users', 'users.id', '=', 'shares.user_id')
            ->join('user_messages', 'user_messages.user_id', '=', 'shares.user_id')
            ->select(
                'shares.id as share_id', // 分享id
                'shares.content', // 分享内容
                'shares.abstract', // 分享摘要
                'users.id as user_id', // 分享拥有者id
                'users.name as user_name', // 分享拥有者姓名
                'user_messages.pic' // 分享拥有者头像
            )
            ->where('likes.user_id', Auth::user()->id)
            ->where('users.active', 0)
            ->where('shares.status', 1)
            ->paginate(10);
        $shareList = array();
        foreach ($shares as $share) {
            $pictures = SharePicture::where('share_id', $share->share_id)
                ->orderBy('order', 'desc')
                ->select('id', 'path', 'order')->get();
            $item = null;
            $item['share'] = $share;
            $item['pictures'] = $pictures;
            array_push($shareList, $item);
        }

        $shareList = new LengthAwarePaginator($shareList, $total = $shares->total(), config('app.page_size'));

        return $shareList;
    }

    /**
     * 获取所有评论过的分享
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCommentedShare()
    {
        $user = Auth::user();
        if ($user == null) {
            return response()->json('false');
        }

        $shares = DB::table('comments')
            ->join('shares', 'shares.id', '=', 'comments.share_id')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->join('users as users_reply', 'users_reply.id', '=', 'comments.usered_id')
            ->join('user_messages', 'user_messages.user_id', '=', 'comments.user_id')
            ->join('user_messages as user_messages_reply', 'user_messages_reply.user_id', '=', 'comments.usered_id')
            ->select(
                'comments.id',// 评论id
                'comments.pid',// 评论pid
                'comments.content', // 评论内容
                'comments.created_at',// 评论时间

                'comments.user_id',// 评论者id
                'users.name', // 评论者名称
                'user_messages.pic', // 评论者头像

                'comments.usered_id',// 被评论者id
                'users_reply.name as reply_user_name', // 被评论者名称
                'user_messages_reply.pic as reply_user_pic', // 被评论者头像

                'comments.share_id', // 分享id
                'shares.abstract as share_abstract', // 分享摘要
                'shares.content as share_content', // 分享内容
                'shares.created_at as share_created_at'// 分享发布时间
            )
            ->where('comments.user_id', $user->id)
            ->where('shares.status', 1)
            ->orderBy('comments.created_at', 'desc')
            ->paginate(10);

        $shareList = array();
        foreach ($shares as $share) {
            $pictures = SharePicture::where('share_id', $share->share_id)
                ->orderBy('order', 'desc')
                ->select('id', 'path', 'order')->get();
            $item = null;
            $item['share'] = $share;
            $item['pictures'] = $pictures;
            array_push($shareList, $item);
        }

        $shareList = new LengthAwarePaginator($shareList, $total = $shares->total(), 10);

        return $shareList;
    }

    /**
     * 获取所有的分享分类
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllShareClassifications()
    {
        return response()->json(ShareClassification::where('pid', null)->orderBy('created_at', 'asc')->select('id', 'name')->get());
    }

}
