<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getPic(Request $request)
    {
        $image_path=config('app.image_path');   //图片根目录
        if ($request->hasFile('pictures')) {
            $pictures = $request->file('pictures');
            $path = $image_path.'/upload/';
            $Extension = $pictures->getClientOriginalExtension();  //图片后缀
            $filename = (time().rand(0,10000)) .'.'. $Extension;  //图片加密
            $pictures->move($path, $filename);
            $filePath = $path.$filename;
        }
        return response()->json("1");
    }
}
