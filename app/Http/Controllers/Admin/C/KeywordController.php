<?php

/**
 * 关键字接口
 */

namespace App\Http\Controllers\Admin\C;

use App\Keyword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Keyword::orderBy('count', 'desc')
            ->orderBy('created_at', 'desc')
            ->select(
                'id', 'name', 'count', 'created_at'
            )
            ->paginate(10);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::user()->can('keyword-add')){
            return response()->json('false');
        }

        $this->validate($request, [
            'name' => 'required|unique:keywords,name|max:10'
        ]);
        $name = $request->input('name');

        $keyword = new Keyword();
        $keyword->name = $name;
        $keyword->save();
        $result = $keyword->id;

        if ($result != null) {
            return response()->json($result);
        } else {
            return response()->json('false');
        }

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

        if(!Auth::user()->can('keyword-edit')){
            return response()->json('false');
        }

        $this->validate($request, [
            'name' => 'required|max:10'
        ]);
        $newName = $request->input('name');

        // 判断名字是否有修改
        $oleKeyword = Keyword::find($id);
        if($oleKeyword->name == $newName) {
            return response()->json('nothing change');
        }

        // 名字不能重复
        $theSame = Keyword::where('name', $newName)->first();
        if($theSame != null){
            return response()->json('the keyword must be different!');
        }

        $oleKeyword->name = $newName;
        $oleKeyword->save();

        return response()->json('true');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(!Auth::user()->can('keyword-delete')){
            return response()->json('false');
        }

        $result = Keyword::destroy($id);
        if($result == 1) {
            return response()->json('true');
        }else {
            return response()->json('false');
        }
    }

    /**
     * 批量删除
     * @param Request $request
     * @return array
     */
    public function batchDestroy(Request $request)
    {

        if(!Auth::user()->can('keyword-batchDelete')){
            return response()->json('false');
        }

        $ids = $request->all();

        $result = Keyword::destroy($ids);

        $keywords = Keyword::orderBy('count', 'desc')
            ->orderBy('created_at', 'desc')
            ->select(
                'id', 'name', 'count', 'created_at'
            )
            ->get();

        $return = [];
        $return['result'] = $result;
        $return['keywords'] = $keywords;
        return $return;
    }

    /**
     * 查询
     * @param Request $request
     * @return mixed
     */
    public function query(Request $request)
    {

        if(!Auth::user()->can('keyword-query')){
            return response()->json('false');
        }

        //request保存
        $request->flash();
        
        $keywords = Keyword::whereRaw('1=1');
        
        $param = $request->input('param');
        
        if($param != null){
            $keywords = $keywords->where('name', '%'.$param.'%');
        }
        
        $keywords = $keywords
            ->orderBy('count', 'desc')
            ->orderBy('created_at', 'desc')
            ->select(
                'id', 'name', 'count', 'created_at'
            )
            ->get();
        
        return $keywords;
        
    }
}
