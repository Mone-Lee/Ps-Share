<?php

/**
 * 超级管理员接口
 */

namespace App\Http\Controllers\Admin\C;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * 获取所有用户，包括按搜索条件获取，按状态获取
     * @param Request $request
     * @return mixed
     */
    public function getAllUser(Request $request)
    {
        //request保存
        $request->flash();

        // 没有条件时获取全部
        $users = User::whereRaw('1=1')
            ->where('name', '<>', 'admin');

        // 搜索内容
        $param = $request->input('param');
        // 状态
        $active = $request->input('active');

        if($param != null){
            $users = $users->where('name', 'like', '%'.$param.'%');
        }

        if($active != null){
            $users = $users->where('active', $active);
        }

        $users = $users->select(
           'id',  'name', 'email', 'active', 'created_at'
        )
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        return $users;

    }

    /**
     * 冻结或解冻用户
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function triggleUser($id)
    {
        if(!Auth::user()->can('user-lock')){
            return response()->json('false');
        }

        $user = User::where('id', $id)
            ->where('name', '<>', 'admin')
            ->first();
        if($user == null){
            return response()->json('false');
        }
        if($user->active == 0){
            $user->active = 1;
            $user->save();
        }else {
            $user->active = 0;
            $user->save();
        }
        return response()->json('true');
    }

    /**
     * 批量冻结
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchLock(Request $request)
    {
        $userIds = $request->all();
        $result = User::where('name', '<>', 'admin')
            ->whereIn('id', $userIds)
            ->update([
               'active' => 1
            ]);
        return response()->json($result);
    }

    /**
     * 批量解冻
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchUnlock(Request $request)
    {
        $userIds = $request->all();
        $result = User::where('name', '<>', 'admin')
            ->whereIn('id', $userIds)
            ->update([
                'active' => 0
            ]);
        return response()->json($result);
    }
}
