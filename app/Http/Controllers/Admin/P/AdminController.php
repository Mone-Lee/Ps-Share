<?php

namespace App\Http\Controllers\Admin\P;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    // 管理员后台页面
    function adminManage(){
        return view('admin.admin-manage');
    }

    // 用户个人空间页面
    function userIndex(){
        return view('admin.user-index');
    }

    // 用户后台管理页面
    function userManage(){
        return view('admin.user-manage');
    }
}
