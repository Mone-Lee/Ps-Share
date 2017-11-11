<?php

/**
 * 分享分类管理接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Share;
use Illuminate\Http\Request;
use App\ShareClassification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShareClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ShareClassification::where('pid', null)
            ->orderBy('created_at', 'asc')
            ->select('id', 'name')
            ->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('shareClassification-add')){
            return response()->json('false');
        }

        // 获取前端传递过来的name，并判断name不能为null或空字符串
        $this->validate($request, [
            'name' => 'required|unique:share_classifications,name|max:10'
        ]);
        $name = $request->input('name');

        // 新增分类
        $shareClassification = new ShareClassification();
        $shareClassification->name = $name;
        $shareClassification->save();
        $result = $shareClassification->id;

        if ($result != null) {
            return response()->json($result);
        } else {
            return response()->json('false');
        }
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
        return ShareClassification::find($id);
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
        if(!Auth::user()->can('shareClassification-edit')){
            return response()->json('false');
        }

        // 获取前端传递过来的name，并判断name不能为null或空字符串
        $this->validate($request, [
            'name' => 'required|max:10'
        ]);
        $name = $request->input('name');

        // 根据id查找对应的分类，判断数据库里的分类名和前端传过来的分类名是否一样
        $shareClassification = ShareClassification::find($id);
        if ($shareClassification == null) {
            return response()->json('Share Classification dose not exist');
        }
        // 分类名一样则不做任何操作
        if ($shareClassification->name == $name) {
            return response()->json('nothing change');
        } else { // 分类名不一样则需先判断传过来的分类名数据库里是否以及存在
            $result = ShareClassification::where('name', $name)->first();
            // 找到同名分类
            if ($result != null) {
                return response()->json('the name already exist');
            } else {
                $shareClassification->name = $name;
                $updateResult = $shareClassification->update();
                if ($updateResult) {
                    return response()->json('true');
                } else {
                    return response()->json('false');
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can('shareClassification-delete')){
            return response()->json('false');
        }

        // 先获取分类下的分享，如果存在分享，则无法删除分类
        $shareClassification = ShareClassification::find($id);
        if ($shareClassification != null) {
            $shares = Share::where('share_classification_id', $shareClassification->id)->get();
            if (sizeof($shares) > 0) {
                return response()->json('has shares');
            }
        } else {
            return response()->json('can not find share classification');
        }
        if (sizeof($shares) > 0) {
            return response()->json('has shares');
        }

        $result = ShareClassification::destroy($id);

        if ($result > 0) {
            return response()->json('true');
        } else {
            return response()->json('false');
        }

    }

    /**
     * Remove the specified resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDestroy(Request $request)
    {
        if(!Auth::user()->can('shareClassification-batchDelete')){
            return response()->json('false');
        }

        $ids = $request->all();

        // 先获取分类下的分享，如果存在分享，则无法删除分类
        $shareClassifications = ShareClassification::whereIn('id', $ids)->get();
        if (sizeof($shareClassifications) != 0) {
            foreach ($shareClassifications as $shareClassification) {
                $shares = Share::where('share_classification_id', $shareClassification->id)->get();
                if (sizeof($shares) > 0) {
                    return response()->json('has shares');
                }
            }
            
        } else {
            return response()->json('can not find share classification');
        }
        

        // 批量删除，返回成功删除的数目
        $result = ShareClassification::destroy($ids);
        // 重新获取所有分类
        $shareClassifications = ShareClassification::where('pid', null)->orderBy('created_at', 'asc')->select('id', 'name')->get();

        $return = [];
        $return['result'] = $result;
        $return['shareClassifications'] = $shareClassifications;

        return response()->json($return);
    }
}
