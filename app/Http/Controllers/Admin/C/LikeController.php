<?php

/**
 * 点赞接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Like;
use App\Share;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
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
     * 点赞
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        if(!Auth::user()->can('like-like')){
            return response()->json('false');
        }

        $this->validate($request, [
            'share_id' => 'required'
        ]);

        // 判断分享是否存在以及是否处于发布状态
        $shareId = $request->input('share_id');
        $share = Share::where('id', $shareId)
            ->where('status', 1)
            ->first();
        if($share == null){
            return response()->json('the share does not exist!');
        }

        $like = new Like();
        $like->user_id = Auth::user()->id;
        $like->share_id = $shareId;
        $like->save();

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
     * 取消点赞
     * @param $shareId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($shareId)
    {
        if(!Auth::user()->can('like-unlike')){
            return response()->json('false');
        }

        $result = Like::where('user_id', Auth::user()->id)
            ->where('share_id', $shareId)
            ->delete();
        if($result == 1){
            return response()->json('true');
        }else {
            return response()->json('false');
        }
    }
}
