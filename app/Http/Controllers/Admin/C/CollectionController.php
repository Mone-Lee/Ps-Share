<?php

/**
 * 收藏接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Collection;
use App\Share;
use App\CollectionClassification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * 取此分类下的所有收藏，分页，查询
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'collectionClassificationId' => 'required'
        ]);

        // 收藏者id
        $followerId = Auth::user()->id;
        // 收藏分类id
        $collectionClassificationId = $request->input('collectionClassificationId');
        // 输入框内容
        $param = $request->input('param');

        $shares = DB::table('collections')
            ->join('shares', 'shares.id', '=', 'collections.share_id')
            ->join('collection_classifications', 'collection_classifications.id', '=', 'collections.collection_classification_id')
            ->select(
                'shares.user_id as user_id',        // 分享拥有者id
                'shares.id as share_id',            // 分享id
                'shares.content',                    // 分享内容
                'shares.abstract',                   // 分享摘要
                'shares.created_at'                  // 分享发布时间
            )
            ->where('collection_classifications.id',$collectionClassificationId)
            ->where('collection_classifications.user_id',$followerId)
            ->where('collections.user_id',$followerId)
            ->orderBy('collections.created_at','desc');


        if($param != null){
            $shares = $shares->where('users.name','like' , '%'.$param.'%');
        }

        $shares->paginate(config('app.page_size'));

        $shareList = array();
        foreach ($shares as $share) {
            $pictures = SharePicture::where('share_id', $share->share_id)
                ->orderBy('order', 'desc')
                ->select('id', 'path', 'order')->get();
            $shareOwner = User::find($share->user_id);
            if($shareOwner != null){
                $share->user_name = $shareOwner->name;
            }else {
                $share->user_name = '';
            }
            $item = null;
            $item['share'] = $share;
            $item['pictures'] = $pictures;
            array_push($shareList, $item);
        }

        $shareList = new LengthAwarePaginator($shareList, $total = $shares->total(), config('app.page_size'));

        return $shareList;
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
     * 收藏分享
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::user()->can('collection-collect')){
            return response()->json('false');
        }

        $this->validate($request, [
            'share_id' => 'required',
            'collection_classification_id' => 'required'
        ]);

        // 收藏者id
        $collectorId = Auth::user()->id;

        // 判断分享是否存在以及是否处于发布状态
        $shareId = $request->input('share_id');
        $share = Share::where('id', $shareId)
            ->where('status', 1)
            ->first();
        if($share == null){
            return response()->json('the share does not exist!');
        }

        // 收藏分类id
        $collectionClassificationId = $request->input('collection_classification_id');
        // 判断收藏分类是否存在
        $collectionClassification = CollectionClassification::where('id', $collectionClassificationId)
            ->where('user_id', $collectorId)
            ->first();
        if ($collectionClassification == null) {
            return response()->json('can\'t find collection calssification!');
        }

        // 判断此分类下是否已经收藏
        $oldCollection = Collection::where('user_id', $collectorId)
            ->where('share_id',$shareId)
            ->where('collection_classification_id', $collectionClassificationId)
            ->first();
        if($oldCollection != null){
            return response()->json('already collected!');
        }

        $collection = new Collection();
        $collection->user_id = $collectorId;
        $collection->share_id = $shareId;
        $collection->collection_classification_id = $collectionClassificationId;
        $collection->save();

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
     * 取消收藏
     * @param $shareId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($shareId)
    {

        if(!Auth::user()->can('collection-uncollect')){
            return response()->json('false');
        }

        $result = Collection::where('user_id', Auth::user()->id)
            ->where('share_id', $shareId)
            ->delete();
        if($result == 1){
            return response()->json('true');
        }else {
            return response()->json('false');
        }
    }

    /**
     * 移动收藏到新分类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(Request $request)
    {

        if(!Auth::user()->can('collection-move')){
            return response()->json('false');
        }

        $this->validate($request, [
            'shareIds' => 'required',
            'oldClassificationId' => 'required',
            'newClassificationId' => 'required',
        ]);

        // 关注者id
        $followerId = Auth::user()->id;
        // 被关注者id
        $shareIds = $request->input('shareIds');
        // 旧分类id
        $oldClassificationId = $request->input('oldClassificationId');
        // 新分类id
        $newClassificationId = $request->input('newClassificationId');

        // 判断新分类是否存在
        $newClassification = CollectionClassification::where('user_id', $followerId)
            ->where('id', $newClassificationId)
            ->first();
        if($newClassification == null) {
            return response()->json('new classification doesn\'t exist!');
        }

        // 判断移动到的新分类下是否已经存在关注用户
        $conflit = Collection::where('user_id', $followerId)
            ->whereIn('share_id', $shareIds)
            ->where('collection_classification_id', $newClassificationId)
            ->get();
        if(sizeof($conflit) != 0){
            return response()->json('already collected!');
        }

        // 更新旧收藏
        Collection::where('user_id', $followerId)
            ->whereIn('share_id', $shareIds)
            ->where('collection_classification_id', $oldClassificationId)
            ->update([
                'collection_classification_id' => $newClassificationId
            ]);

        return response()->json('true');

    }

    /**
     * 复制收藏到新分类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function copy(Request $request)
    {

        if(!Auth::user()->can('collection-copy')){
            return response()->json('false');
        }

        $this->validate($request, [
            'shareIds' => 'required',
            'newClassificationId' => 'required',
        ]);

        // 关注者id
        $followerId = Auth::user()->id;
        // 被关注者id
        $shareIds = $request->input('shareIds');
        // 新分类id
        $newClassificationId = $request->input('newClassificationId');

        // 判断新分类是否存在
        $newClassification = CollectionClassification::where('user_id', $followerId)
            ->where('id', $newClassificationId)
            ->first();
        if($newClassification == null) {
            return response()->json('new classification doesn\'t exist!');
        }

        // 判断复制到的新分类下是否已经存在关注用户
        $conflit = Collection::where('user_id', $followerId)
            ->whereIn('share_id', $shareIds)
            ->where('collection_classification_id', $newClassificationId)
            ->get();
        if(sizeof($conflit) != 0){
            return response()->json('already collected!');
        }

        foreach ($shareIds as $shareId) {
            // 新分类下的新关注
            $collection = new Collection();
            $collection->user_id = $followerId;
            $collection->share_id = $shareId;
            $collection->collection_classification_id = $newClassificationId;
            $collection->save();
        }

        return response()->json('true');
    }
}
