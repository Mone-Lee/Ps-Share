<?php

/**
 * 收藏分类接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Collection;
use App\CollectionClassification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CollectionClassificationController extends Controller
{
    /**
     * 获取所有收藏分类，附带被收藏的分享的第一张图片
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!Auth::user()->can('collectionClassification-get-all')){
            return response()->json('false');
        }

        $collectionClassifications = CollectionClassification::where('user_id', Auth::user()->id)
            ->select('id', 'name', 'user_id')
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->get();

        $collectionClassificationList = array();
        foreach ($collectionClassifications as $collectionClassification) {
            $sharePics = DB::table('shares')
                ->join('collections', 'collections.share_id', '=', 'shares.id')
                ->join('share_pictures', 'share_pictures.share_id', '=', 'shares.id')
                ->select(
                    'share_pictures.path as pic',
                    'share_pictures.share_id'
                )
                ->where('collections.collection_classification_id', $collectionClassification->id)
                ->where('share_pictures.order', 1)
                ->orderBy('collections.created_at', 'desc')
                ->take(4)
                ->get();
            $item = null;
            $item['collectionClassification'] = $collectionClassification;
            $item['sharePics'] = $sharePics;
            array_push($collectionClassificationList, $item);
        }

        return $collectionClassificationList;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::user()->can('collectionClassification-add')){
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
        $collectionClassification = CollectionClassification::where('name', $name)
            ->where('user_id', $user->id)
            ->first();
        if ($collectionClassification != null) {
            return response()->json('the classification already exist!');
        }

        $newCollectionClassification = new CollectionClassification();
        $newCollectionClassification->name = $name;
        $newCollectionClassification->user_id = $user->id;
        $newCollectionClassification->save();

        return response()->json($newCollectionClassification->id);
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
     * 获取待编辑的分类名
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collectionClassification = CollectionClassification::where('id', $id)
            ->where('name', '<>', '默认')
            ->where('user_id', Auth::user()->id)
            ->select('id', 'name', 'user_id')
            ->first();
        return $collectionClassification;
    }

    /**
     * 保存编辑的分类名
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(!Auth::user()->can('collectionClassification-edit')){
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
        $collectionClassification = CollectionClassification::where('id', $id)
            ->where('name', '<>', '默认')
            ->where('user_id', $user->id)
            ->first();
        if ($collectionClassification == null) {
            return response()->json('false');
        }

        // 判断新分类是否存在
        $newCollectionClassification = CollectionClassification::where('name', $name)
            ->where('user_id', $user->id)
            ->first();
        if ($newCollectionClassification != null) {
            return response()->json('the classification already exist!');
        }

        // 更新分类名
        $collectionClassification->name = $name;
        $collectionClassification->save();

        return response()->json('true');
    }

    /**
     * 删除分类
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(!Auth::user()->can('collectionClassification-delete')){
            return response()->json('false');
        }

        $user = Auth::user();
        if ($user == null) {
            return response()->json('please login first');
        }
        // 判断分类是否存在
        $collectionClassification = CollectionClassification::where('id', $id)
            ->where('name', '<>', '默认')
            ->where('user_id', $user->id)
            ->first();
        if ($collectionClassification == null) {
            return response()->json('classification doesn\'t exist');
        }

        // 获取默认分类id
        $defaultCollectionClassification = CollectionClassification::where('name', '默认')
            ->where('user_id', $user->id)
            ->first();
        if ($defaultCollectionClassification == null) {
            return response()->json('false');
        }
        $defaultCollectionClassificationId = $defaultCollectionClassification->id;

        // 将此分类下的所有关注转移到默认分类
        $collections = Collection::where('user_id', $user->id)
            ->where('collection_classification_id', $id)
            ->update(['collection_classification_id' => $defaultCollectionClassificationId]);

        $result = $collectionClassification->delete();

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
        if(!Auth::user()->can('collectionClassification-triggle')){
            return response()->json('false');
        }

        $collectionClassification = CollectionClassification::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if($collectionClassification == null) {
            return response()->json('false');
        }
        $status = $collectionClassification->status;
        $collectionClassification->status = ($status == 1 ? 0: 1);
        $collectionClassification->save();
        return response()->json('true');
    }
}
