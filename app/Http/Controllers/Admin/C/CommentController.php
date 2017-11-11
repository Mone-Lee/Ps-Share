<?php

/**
 * 评论接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Comment;
use App\Share;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use KWFilter;

class CommentController extends Controller
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
     * 评论
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('comment-*')){
            return response()->json('false');
        }

        $this->validate($request, [
            'content' => 'required',
            'share_id' => 'required',
            'usered_id' => 'required'
        ]);
        // 被回复评论id
        $pid = $request->input('pid');
        // 父评论id
        $commentId = $request->input('comment_id');
        // 评论内容
        $content = $request->input('content');
        // 分享id
        $shareId = $request->input('share_id');
        // 评论者id
        $userId = Auth::user()->id;
        // 被评论者id
        $useredId = $request->input('usered_id');
        
        // 过滤评论内容
        $filterResult = KWFilter::filter($content);
        if($filterResult != -1){
            return response()->json($filterResult);
        }

        // 判断分享是否存在以及是否处于发布状态
        $share = Share::where('id', $shareId)
            ->where('status', 1)
            ->first();
        if($share == null){
            return response()->json('the share does not exist!');
        }

        $comment = new Comment();
        if($pid != null && $pid != -1) {
            $comment->pid = $pid;
        }
        if($commentId != null && $commentId != -1) {
            $comment->comment_id = $commentId;
        }
        $comment->content = $content;
        $comment->share_id = $shareId;
        $comment->user_id = $userId;
        $comment->usered_id = $useredId;
        $comment->save();

        return response()->json('true');
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
        //
    }

    /**
     * 删除评论
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Comment::destroy($id);
        if($result == 1){
            return response()->json('true');
        }else {
            return response()->json('false');
        }
    }
}
