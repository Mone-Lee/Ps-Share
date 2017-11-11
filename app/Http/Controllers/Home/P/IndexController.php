<?php

namespace App\Http\Controllers\Home\P;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    // 首页视图
    function index(){
        return view('home.index');
    }

    // 分享详情页
    function shareDetail($shareId){
        return view('home.share-detail',['shareId' => $shareId]);
    }
    
    // 分享列表页
    function shareList(){
        return view('home.share-list');
    }
}
