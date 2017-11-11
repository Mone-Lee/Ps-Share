<?php

/**
 * 关注接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Follow;
use App\FollowClassification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{

    /**
     * 取此分类下的所有关注者，分页，查询
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'followClassificationId' => 'required'
        ]);

        // 关注者id
        $followerId = Auth::user()->id;
        // 关注分类id
        $followClassificationId = $request->input('followClassificationId');
        // 输入框内容
        $param = $request->input('param');

        $follows = DB::table('follows')
            ->join('users', 'users.id', '=', 'follows.followed_id')
            ->join('user_messages', 'user_messages.user_id', '=', 'follows.followed_id')
            ->join('follow_classifications', 'follow_classifications.id', '=', 'follows.follow_classification_id')
            ->select(
                'users.id as followed_id',
                'users.name as followed_name',
                'user_messages.introduction'
            )
            ->where('follows.follower_id',$followerId)
            ->where('follow_classifications.id', $followClassificationId)
            ->orderBy('follows.created_at','desc');

        if($param != null){
            $shares = $follows->where('users.name','like' , '%'.$param.'%');
        }

        $follows = $follows->paginate(config('app.page_size'));

        return $follows;
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
     * 关注用户
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::user()->can('follow-follow')){
            return response()->json('false');
        }

        $this->validate($request, [
            'followed_id' => 'required',
            'follow_classification_id' => 'required'
            ]);
        // 关注者id
        $followerId = Auth::user()->id;
        // 被关注者id
        $followedId = $request->input('followed_id');
        // 关注分类id
        $followClassificationId = $request->input('follow_classification_id');

        // 判断被关注者是否存在以及是否被冻结
        $followedUser = User::find($followedId);
        if ($followedUser == null) {
            return response()->json('the user does not exist!');
        } else if ($followedUser->active == 1) {
            return response()->json('the user has been locked!');
        }

        // 判断关注分类是否存在
        $followClassification = FollowClassification::where('id', $followClassificationId)
            ->where('user_id', $followerId)
            ->first();
        if ($followClassification == null) {
            return response()->json('can\'t find follow calssification!');
        }

        // 如果没有关注分类id，则使用默认的关注分类id
//        if($followClassificationId == null){
//            $defaultFollowClassification = FollowClassification::where('name', '默认')
//                ->where('user_id', $followerId)
//                ->first();
//            if($defaultFollowClassification != null){
//                $followClassificationId = $defaultFollowClassification->id;
//            }else {
//                return response()->json('can\'t find default follow calssification!');
//            }
//        }
        
        // 判断此分类下是否已关注过
        $oldFollow = Follow::where('follower_id', $followerId)
            ->where('followed_id', $followedId)
            ->where('follow_classification_id', $followClassificationId)
            ->first();
        if($oldFollow != null){
            return response()->json('already followed!');
        }

        $follow = new Follow();
        $follow->follower_id = $followerId;
        $follow->followed_id = $followedId;
        $follow->follow_classification_id = $followClassificationId;
        $follow->save();

        return response()->json('true');
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
     * 取消关注用户
     * @param $followedId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($followedId)
    {

        if(!Auth::user()->can('follow-unfollow')){
            return response()->json('false');
        }

        // 关注者id
        $followerId = Auth::user()->id;

        // 判断被关注者是否存在
        $followedUser = User::find($followedId);
        if ($followedUser == null) {
            return response()->json('the user does not exist!');
        }

        $result = Follow::where('follower_id', $followerId)
            ->where('followed_id', $followedId)
            ->delete();
        
        if($result == 1){
            return response()->json('true');
        }else {
            return response()->json('false');
        }
    }

    /**
     * 移动关注到新分类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(Request $request)
    {

        if(!Auth::user()->can('follow-move')){
            return response()->json('false');
        }

        $this->validate($request, [
            'followedIds' => 'required',
            'oldClassificationId' => 'required',
            'newClassificationId' => 'required',
        ]);

        // 关注者id
        $followerId = Auth::user()->id;
        // 被关注者id
        $followedIds = $request->input('followedIds');
        // 旧分类id
        $oldClassificationId = $request->input('oldClassificationId');
        // 新分类id
        $newClassificationId = $request->input('newClassificationId');

        // 判断新分类是否存在
        $newClassification = FollowClassification::where('user_id', $followerId)
            ->where('id', $newClassificationId)
            ->first();
        if($newClassification == null) {
            return response()->json('new classification doesn\'t exist!');
        }

        // 判断移动到的新分类下是否已经存在关注用户
        $conflit = Follow::where('follower_id', $followerId)
            ->whereIn('followed_id', $followedIds)
            ->where('follow_classification_id', $newClassificationId)
            ->get();
        if(sizeof($conflit) != 0){
            return response()->json('already followed!');
        }

        // 更新旧关注
        Follow::where('follower_id', $followerId)
            ->whereIn('followed_id', $followedIds)
            ->where('follow_classification_id', $oldClassificationId)
            ->update([
                'follow_classification_id' => $newClassificationId
            ]);

        return response()->json('true');

    }

    /**
     * 复制关注到新分类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function copy(Request $request)
    {

        if(!Auth::user()->can('follow-copy')){
            return response()->json('false');
        }

        $this->validate($request, [
            'followedIds' => 'required',
            'newClassificationId' => 'required',
        ]);

        // 关注者id
        $followerId = Auth::user()->id;
        // 被关注者id
        $followedIds = $request->input('followedIds');
        // 新分类id
        $newClassificationId = $request->input('newClassificationId');

        // 判断新分类是否存在
        $newClassification = FollowClassification::where('user_id', $followerId)
            ->where('id', $newClassificationId)
            ->first();
        if($newClassification == null) {
            return response()->json('new classification doesn\'t exist!');
        }

        // 判断复制到的新分类下是否已经存在关注用户
        $conflit = Follow::where('follower_id', $followerId)
            ->whereIn('followed_id', $followedIds)
            ->where('follow_classification_id', $newClassificationId)
            ->get();
        if(sizeof($conflit) != 0){
            return response()->json('already followed!');
        }

        foreach ($followedIds as $followedId) {
            // 新分类下的新关注
            $follow = new Follow();
            $follow->follower_id = $followerId;
            $follow->followed_id = $followedId;
            $follow->follow_classification_id = $newClassificationId;
            $follow->save();
        }
        

        return response()->json('true');
    }
}
