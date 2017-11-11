<?php

/**
 * 关注分类接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Follow;
use App\FollowClassification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowClassificationController extends Controller
{
    /**
     * 获取所有的关注分类,附带被关注用户头像
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!Auth::user()->can('followClassification-get-all')){
            return response()->json('false');
        }

        // 关注分类
        $followClassifications = FollowClassification::where('user_id', Auth::user()->id)
            ->select('id', 'name', 'user_id')
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->get();
        $followClassificationList = array();
        foreach ($followClassifications as $followClassification) {
            $userPics = DB::table('users')
                ->join('follows', 'follows.followed_id', '=', 'users.id')
                ->join('user_messages', 'user_messages.user_id', '=', 'users.id')
                ->select(
                    'user_messages.pic',
                    'users.name'
                )
                ->where('follows.follow_classification_id', $followClassification->id)
                ->orderBy('follows.created_at', 'desc')
                ->take(4)// 只取前四个
                ->get();
            $item = null;
            $item['followClassification'] = $followClassification;
            $item['userPics'] = $userPics;
            array_push($followClassificationList, $item);
        }

        return $followClassificationList;
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
     * 新增分类
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::user()->can('followClassification-add')){
            return response()->json('false');
        }

        $this->validate($request, [
            'name' => 'required|max:10'
        ]);

        $user = Auth::user();
        if ($user == null) {
            return response()->json('please login first');
        }

        // 获取分类名
        $name = $request->input('name');

        // 判断分类是否存在
        $followClassification = FollowClassification::where('name', $name)
            ->where('user_id', $user->id)
            ->first();
        if ($followClassification != null) {
            return response()->json('the classification already exist!');
        }

        $newFollowClassification = new FollowClassification();
        $newFollowClassification->name = $name;
        $newFollowClassification->user_id = $user->id;
        $newFollowClassification->save();

        return response()->json($newFollowClassification->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 获取待编辑的分类名
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $followClassification = FollowClassification::where('id', $id)
            ->where('name', '<>', '默认')
            ->where('user_id', Auth::user()->id)
            ->select('id', 'name', 'user_id')
            ->first();
        return $followClassification;
    }

    /**
     * 保存编辑的分类名
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(!Auth::user()->can('followClassification-edit')){
            return response()->json('false');
        }

        $this->validate($request, [
            'name' => 'required|max:10'
        ]);

        $user = Auth::user();
        if ($user == null) {
            return response()->json('please login first');
        }

        // 获取新分类名
        $name = $request->input('name');

        // 判断旧分类是否存在
        $followClassification = FollowClassification::where('id', $id)
            ->where('name', '<>', '默认')
            ->where('user_id', $user->id)
            ->first();
        if ($followClassification == null) {
            return response()->json('false');
        }

        // 判断新分类是否存在
        $newFollowClassification = FollowClassification::where('name', $name)
            ->where('user_id', $user->id)
            ->first();
        if ($newFollowClassification != null) {
            return response()->json('the classification already exist!');
        }

        // 更新分类名
        $followClassification->name = $name;
        $followClassification->save();

        return response()->json('true');
    }

    /**
     * 删除分类
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(!Auth::user()->can('followClassification-delete')){
            return response()->json('false');
        }

        $user = Auth::user();
        if ($user == null) {
            return response()->json('please login first');
        }
        // 判断分类是否存在
        $followClassification = FollowClassification::where('id', $id)
            ->where('name', '<>', '默认')
            ->where('user_id', $user->id)
            ->first();
        if ($followClassification == null) {
            return response()->json('classification doesn\'t exist');
        }

        // 获取默认分类id
        $defaultFollowClassification = FollowClassification::where('name', '默认')
            ->where('user_id', $user->id)
            ->first();
        if ($defaultFollowClassification == null) {
            return response()->json('false');
        }
        $defaultFollowClassificationId = $defaultFollowClassification->id;

        // 将此分类下的所有关注转移到默认分类
        $follows = Follow::where('follower_id', $user->id)
            ->where('follow_classification_id', $id)
            ->update(['follow_classification_id' => $defaultFollowClassificationId]);

        $result = $followClassification->delete();

        if ($result != 1) {
            return response()->json('delete fail');
        }

        return response()->json('true');
    }

    /**
     * 隐藏或显示分类
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function triggle($id)
    {

        if(!Auth::user()->can('followClassification-triggle')){
            return response()->json('false');
        }

        $followClassification = FollowClassification::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if($followClassification == null) {
            return response()->json('false');
        }
        $status = $followClassification->status;
        $followClassification->status = ($status == 1 ? 0: 1);
        $followClassification->save();
        return response()->json('true');
    }

}