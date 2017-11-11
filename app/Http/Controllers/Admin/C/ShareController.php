<?php


/**
 * 分享管理接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Share;
use App\SharePicture;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use KWFilter;

class ShareController extends Controller
{
    /**
     * 首页获取所有分享
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 使用App\Http\Controllers\Home\C\IndexController里面的getAllShares()
    }

    /**
     *
     * 用户空间的所有分享
     *
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexUser($userId)
    {
        // 使用App\Http\Controllers\Home\C\IndexController里面的getUserAllIndexShares()
    }

    /**
     *
     * 获取个人后台管理页面的所有分享
     *
     * @return mixed
     */
    public function indexAdmin()
    {
        $shares = DB::table('shares')
            ->join('share_classifications', 'share_classifications.id', '=', 'shares.share_classification_id')
            ->select(
                'share_classifications.id as sc_id',        // 分类id
                'share_classifications.name as sc_name',        // 分类名
                'shares.id as id',                              //  分享id
                'shares.content',                               // 分享内容
                'shares.status',                                 // 分享的状态
                'shares.created_at',                            // 发布时间
                'shares.abstract')// 分享摘要
            ->where('shares.user_id', Auth::user()->id)
            ->orderBy('shares.created_at', 'desc')
            ->paginate(config('app.page_size'));
        $shareList = array();
        foreach ($shares as $share) {
            $pictures = SharePicture::where('share_id', $share->id)
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 新增分享
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::user()->can('share-add')){
            return response()->json('false');
        }

        $this->validate($request, [
            'share_classification_id' => 'required',
            'pictures' => 'required',
            'status' => 'required|between:0,1',
            'abstract' => 'max:50',
            'content' => 'max:300',
        ]);

        $share_classification_id = $request->input('share_classification_id');
        $abstract = $request->input('abstract');
        $content = $request->input('content');
        $status = $request->input('status');

        // 过滤摘要内容
        $filterResult = KWFilter::filter($abstract);
        if($filterResult != -1){
            return response()->json($filterResult);
        }

        // 过滤分享内容
        $filterResult = KWFilter::filter($content);
        if($filterResult != -1){
            return response()->json($filterResult);
        }

        $share = new Share();
        $share->share_classification_id = $share_classification_id;
        $share->abstract = $abstract;
        $share->content = $content;
        if ($status != null) {
            $share->status = $status;
        }
        $share->user_id = Auth::user()->id;
        $result = $share->save();

        if ($result == null) {
            return response()->json('save share fail!');
        }

        // 图片根目录
        $image_path = config('app.image_path');
        // 图片顺序
        $order = 1;
        if ($request->hasFile('pictures')) {
            // 获取图片
            $pictures = $request->file('pictures');
            // 图片路径
            $path = $image_path . '/upload/';
            foreach ($pictures as $picture) {
                //图片后缀
                $Extension = $picture->getClientOriginalExtension();
                //图片名
                $filename = (time() . rand(0, 10000)) . '.' . $Extension;
                $picture->move($path, $filename);
                $filePath = $path . $filename;

                $sharePicture = new SharePicture();
                $sharePicture->path = $filePath;
                $sharePicture->order = $order++;
                $sharePicture->share_id = $share->id;
                $sharePicture->save();
            }
        }

        return response()->json($share->id);

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
     * 删除单个分享
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(!Auth::user()->can('share-delete')){
            return response()->json('false');
        }

        // 先查找分享
        $share = Share::find($id);
        // 找不到则返回
        if ($share == null) {
            return resopnse()->json('share does not exist');
        }
        // 根据分享的id寻找对应的所有图片
        $pictures = SharePicture::where('share_id', $share->id)->get();
        // 删除服务器上的图片
        foreach ($pictures as $picture) {
            File::delete($picture->path);
        }
        // 删除数据库里的图片路径
        $pictureResult = SharePicture::where('share_id', $share->id)->delete();
        // 删除分享
        Share::destroy($id);
        return response()->json('true');
    }

    /**
     *
     * 批量删除分享
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDestroy(Request $request)
    {
        if(!Auth::user()->can('share-batchDelete')){
            return response()->json('false');
        }

        $ids = $request->all();

        $shares = Share::whereIn('id', $ids)->get();

        foreach ($shares as $share) {
            // 根据分享的id寻找对应的所有图片
            $pictures = SharePicture::where('share_id', $share->id)->get();
            // 删除服务器上的图片
            foreach ($pictures as $picture) {
                File::delete($picture->path);
            }
            // 删除数据库里的图片路径
            $pictureResult = SharePicture::where('share_id', $share->id)->delete();
        }

        $result = Share::destroy($ids);

        return response()->json($result);

    }

    /**
     *
     * 查询
     *
     * @param Request $request
     * @return array|LengthAwarePaginator
     */
    public function query(Request $request)
    {

        if(!Auth::user()->can('share-query')){
            return response()->json('false');
        }

        //request保存
        $request->flash();

        // 建立恒等式用于当无附加条件时获得所有
        $shares = DB::table('shares')
            ->join('share_classifications', 'share_classifications.id', '=', 'shares.share_classification_id')
            ->select(
                'share_classifications.id as sc_id',            // 分类id
                'share_classifications.name as sc_name',        // 分类名
                'shares.id as id',                              //  分享id
                'shares.content',                               // 分享内容
                'shares.status',                                 // 分享的状态
                'shares.created_at',                            // 发布时间
                'shares.abstract'                               // 分享摘要
            )
            ->whereRaw('1=1');

        $abstract = $request->input('abstract');
        $status = $request->input('status');

        if ($abstract != null) {
            $shares = $shares->where('abstract', 'like', '%' . $abstract . '%');
        }

        if ($status != null && $status != -1) {
            $shares = $shares->where('status', $status);
        }

        $result = $shares
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(config('app.page_size'));

        $shareList = array();
        foreach ($result as $share) {
            $pictures = SharePicture::where('share_id', $share->id)
                ->orderBy('order', 'desc')
                ->select('id', 'path', 'order')->get();
            $item = null;
            $item['share'] = $share;
            $item['pictures'] = $pictures;
            array_push($shareList, $item);
        }

        $shareList = new LengthAwarePaginator($shareList, $total = $result->total(), config('app.page_size'));

        return $shareList;

    }

    /**
     * 屏蔽或发布分享
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function triggleShare($shareId)
    {

        if(!Auth::user()->can('share-triggle')){
            return response()->json('false');
        }

        if ($shareId == null) {
            return response()->json('false');
        }

        $share = Share::where('id', $shareId)
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($share->status == 3) {
            return response()->json('the share is forbidden');
        }

        $share->status = ($share->status == 1 ? 2 : 1);
        $share->save();

        return response()->json('true');

    }


}
