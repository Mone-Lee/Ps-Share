<?php

/**
 * 用户行为接口
 */

namespace App\Http\Controllers\Admin\C;

use App\UserMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * 获取用户基本信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserMsg()
    {
        // 获取当前登录用户
        $user = Auth::user();

        if ($user == null) {
            return response()->json('false');
        }

        // 获取用户id
        $userId = $user->id;

        $userMsg = UserMessage::where('user_id', $userId)
            ->select('user_id', 'pic', 'introduction', 'sex')
            ->first();
        if ($userMsg != null) {
            $userMsg->name = $user->name;
        }

        return $userMsg;

    }

    /**
     * 修改用户基本信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveUserMsg(Request $request)
    {
        $this->validate($request, [
            'sex' => 'between:0,1',
            'introduction' => 'max:140'
        ]);

        // 图片路径
        $pic = '';
        // 获取图片
        if ($request->hasFile('picture')) {
            // 图片根目录
            $image_path = config('app.image_path');
            // 获取图片
            $picture = $request->file('picture');
            // 图片路径
            $path = $image_path . '/upload/';
            //图片后缀
            $Extension = $picture->getClientOriginalExtension();
            //图片名
            $filename = (time() . rand(0, 10000)) . '.' . $Extension;
            // 存储图片
            $picture->move($path, $filename);
            $pic = $path . $filename;
        }
        // 获取性别
        $sex = $request->input('sex');
        // 获取简介
        $introduction = $request->input('introduction');

        // 获取用户信息
        $userMsg = UserMessage::where('user_id', Auth::user()->id)->first();

        if ($pic != '') {
            $userMsg->pic = $pic;
        }

        if ($sex != null) {
            $userMsg->sex = $sex;
        }

        if ($introduction != null) {
            $userMsg->introduction = $introduction;
        }

        $userMsg->save();

        return response()->json('true');

    }

    /**
     * 更新密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);
        $user = Auth::user();
        if ($user == null) {
            return response()->json('false');
        }

        // 新密码
        $newPassword = $request->input('password');

        // 更新密码
        $user->password = bcrypt($newPassword);
        $user->save();

        return response()->json('true');
    }



}
