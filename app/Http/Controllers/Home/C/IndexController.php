<?php

/**
 * 首页接口
 */

namespace App\Http\Controllers\Home\C;

use App\Collection;
use App\Follow;
use App\Like;
use App\ReportClassification;
use App\Share;
use App\ShareClassification;
use App\SharePicture;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{
    /**
     * 获取所有分享分类
     * @return mixed
     */
    public function getAllClassification()
    {
        return ShareClassification::where('pid', null)
            ->orderBy('created_at', 'asc')
            ->select('id', 'name')
            ->get();
    }

    /**
     * 获取用户个人所有的分享分类
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUserClassification($userId)
    {
        $userClassification = DB::table('shares')
            ->join('share_classifications', 'share_classifications.id', '=', 'shares.share_classification_id')
            ->select(
                'share_classifications.id',
                'share_classifications.name'
            )
            ->where('shares.user_id', $userId)
            ->groupBy('share_classifications.id')
            ->groupBy('share_classifications.name')
            ->get();
        return response()->json($userClassification);
    }

    /**
     * 首页获取所有分享，默认获取全部
     * @return array|LengthAwarePaginator
     */
    public function getAllShares()
    {
        $shares = DB::table('shares')
            ->join('users', 'users.id', '=', 'shares.user_id')
            ->join('share_classifications', 'share_classifications.id', '=', 'shares.share_classification_id')
            ->select(
                'share_classifications.id as sc_id',           // 分类id
                'share_classifications.name as sc_name',      // 分类名
                'shares.id as id',                              // 分享id
                'shares.content',                               //分享内容
                'shares.abstract',                              // 分享摘要
                'shares.created_at',                            // 发布时间
                'users.id as user_id',                          // 用户id
                'users.name as user_name')// 用户名称
            ->where('users.active', 0)
            ->where('shares.status', 1)
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
     * 用户空间的所有分享
     * @param $userId
     * @return array|\Illuminate\Http\JsonResponse|LengthAwarePaginator
     */
    public function getUserAllIndexShares($userId)
    {
        $user = null;

        // $userId不存在，表示访问自己的个人空间
        if ($userId == null) {
            $user = Auth::user();
            $userId = $user->id;
        } else {
            // $userId存在，表示访问其他人的个人空间
            $user = User::find($userId);

            // 访问其他用户个人空间，如果此用户被冻结，则无法查看分享
            if ($user->active == 1) {
                return response()->json('lock');
            }
        }

        $shares = DB::table('shares')
            ->join('share_classifications', 'share_classifications.id', '=', 'shares.share_classification_id')
            ->select(
                'share_classifications.id as sc_id',       // 分类id
                'share_classifications.name as sc_name',       // 分类名
                'shares.id as id',                              // 分享id
                'shares.content',                               // 分享内容
                'shares.created_at',                            // 发布时间
                'shares.abstract')// 分享摘要
            ->where('shares.user_id', $userId)
            ->where('shares.status', 1)
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
     * 首页查询或按分类获取分享，以及分页
     * @param Request $request
     * @return array|LengthAwarePaginator
     */
    public function queryShare(Request $request)
    {
        //request保存
        $request->flash();

        // 建立恒等式用于当无附加条件时获得所有
        $shares = DB::table('shares')
            ->join('users', 'users.id', '=', 'shares.user_id')
            ->join('share_classifications', 'share_classifications.id', '=', 'shares.share_classification_id')
            ->select(
                'share_classifications.id as sc_id',           // 分类id
                'share_classifications.name as sc_name',        // 分类名
                'shares.id as id',                              // 分享id
                'shares.content',                               //分享内容
                'shares.abstract',                              // 分享摘要
                'shares.created_at',                            // 发布时间
                'users.id as user_id',                          // 用户id
                'users.name as user_name')// 用户名称
            ->whereRaw('1=1');

        // 输入框内容
        $param = $request->input('param');
        // 分类
        $classificationId = $request->input('classificationId');

        if ($param != null) {
            $shares = $shares->where('content', 'like', '%' . $param . '%');
        }

        if ($classificationId != null && $classificationId > 0) {
            $shares = $shares->where('shares.share_classification_id', $classificationId);
        }

        $result = $shares
            ->where('users.active', 0)
            ->where('shares.status', 1)
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
     * 用户查询或按分类获取分享，以及分页
     * @param Request $request
     * @return array|LengthAwarePaginator
     */
    public function queryUserShare(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required'
        ]);

        //request保存
        $request->flash();

        // 建立恒等式用于当无附加条件时获得所有
        $shares = DB::table('shares')
            ->join('users', 'users.id', '=', 'shares.user_id')
            ->join('share_classifications', 'share_classifications.id', '=', 'shares.share_classification_id')
            ->select(
                'share_classifications.id as sc_id', // 分类id
                'share_classifications.name as sc_name', // 分类名
                'shares.id as id',                              // 分享id
                'shares.content',                               //分享内容
                'shares.abstract',                              // 分享摘要
                'shares.created_at'                            // 发布时间
            )
            ->whereRaw('1=1');

        // 用户id
        $userId = $request->input('userId');
        // 分类名
        $classificationId = $request->input('classificationId');
        // 输入框内容
        $param = $request->input('param');

        if ($param != null) {
            $shares = $shares->where('content', 'like', '%' . $param . '%');
        }

        $shares = $shares->where('user_id', $userId);

        if ($classificationId != null) {
            $shares = $shares->where('share_classifications.id', $classificationId);
        }

        $result = $shares
            ->where('users.active', 0)
            ->where('shares.status', 1)
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
     * 获取用户详细个人信息
     * @param $userId
     * @return mixed
     */
    public function getUserMsg($userId)
    {
        $userMsg = DB::table('users')
            ->join('user_messages', 'user_messages.user_id', '=', 'users.id')
            ->select(
                'users.id as user_id',
                'user_messages.pic',
                'users.name',
                'user_messages.introduction',
                'user_messages.sex'
            )
            ->where('users.id', $userId)
            ->where('users.active', 0)
            ->first();
        return $userMsg;
    }

    /**
     * 获取个人首页的所有信息：个人详细信息、关注、收藏、分享
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndexUserMsg($userId)
    {
        // 用户被冻结则直接返回
        $user = User::find($userId);
        if($user == null){
            return response()->json('can\'t find user');
        }
        if ($user->active == 1) {
            return response()->json('lock');
        }
        // 用户个人详细信息
        $userMsg = $this->getUserMsg($userId);
        // 获取关注数
        $follows = Follow::where('follower_id', $userMsg->user_id)->count();
        // 获取收藏数
        $collections = Collection::where('user_id', $userMsg->user_id)->count();
        // 用户所有的分类
        $shareClassifications = $this->getAllUserClassification($userId);
        // 分享
        $shares = $this->getUserAllIndexShares($userId);

        $indexUserMsg = array();
        $indexUserMsg['userMsg'] = $userMsg;
        $indexUserMsg['follows'] = $follows;
        $indexUserMsg['collections'] = $collections;
        $indexUserMsg['shareClassifications'] = $shareClassifications->getData();
        $indexUserMsg['shares'] = $shares;

        return response()->json($indexUserMsg);
    }

    /**
     * 获取点赞榜（全部、最近一周、今天）
     * @param $type
     */
    public function getLikesBoard(Request $request)
    {
        date_default_timezone_set('PRC');
        // 开始时间
        $beginTime = '';
        // 结束时间，默认当前
        $endTime = date('Y-m-d H:i:s', time());

        // 获取显示类型
        $type = $request->input('type');
        if ($type == null) {
            $type = 1;
        }

        switch ($type) {
            case 1: //全部
                $beginTime = '1970-01-01 00:00:00';
                break;
            case 2: //最近一周
                $beginTime = date('Y-m-d H:i:s', strtotime('-7 days'));
                break;
            case 3: // 今天
                $beginTime = date('Y-m-d 00:00:00', time());
                break;
            default: // 默认全部
                $beginTime = '1970-01-01 00:00:00';
                break;
        }

        $likeBoard = DB::select('
            select
            a.share_id,
            share_first_picture,
            a.share_abstract,
            a.share_content,
            a.share_created_at,
            a.user_id,
            a.user_name,
            a.user_pic,
            b.total_likes
            from
            (select 
            shares.id as share_id,
            shares.abstract as share_abstract,
            shares.content as share_content,
            shares.created_at as share_created_at,
            users.id as user_id,
            users.name as user_name,
            user_messages.pic as user_pic,
            share_pictures.path as share_first_picture
            from shares
            inner join users on users.id = shares.user_id
            inner join share_pictures on share_pictures.share_id = shares.id
            inner join user_messages on user_messages.user_id = shares.user_id
            where share_pictures.order = 1
            ) a
            left join
            (select 
            likes.share_id,
            count(*) as total_likes
            from shares left join likes on likes.share_id = shares.id
            where shares.created_at between ? and ?
            group by likes.share_id
            ) b
            on a.share_id = b.share_id
            order by total_likes desc, a.share_created_at desc 
        ', [$beginTime, $endTime]);

        // 获取分页下标
        $page = $request->input('page');
        if ($page == null) {
            $page = 1;
        }
        // 获取每页的页数
        $paginate = config('app.page_size');

        $shares = array_slice($likeBoard, $paginate * ($page - 1), $paginate);

        $shares = new LengthAwarePaginator($shares, sizeof($likeBoard), $paginate);

        return $shares;

    }

    /**
     * 获取用户的关注总数
     * @param $userId
     * @return mixed
     */
    public function getUserFollowNumbers($userId)
    {
        return Follow::where('follower_id', $userId)
            ->count();
    }

    /**
     * 获取用户的分享总数
     * @param $userId
     * @return mixed
     */
    public function getUserShareNumber($userId)
    {
        return Share::where('user_id', $userId)
            ->count();
    }

    /**
     * 获取用户的收藏总数
     * @param $userId
     * @return mixed
     */
    public function getUserCollectionNumber($userId)
    {
        return Collection::where('user_id', $userId)
            ->count();
    }

    /**
     * 获取所有举报分类
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllReports()
    {
        return ReportClassification::select('id', 'name')
            ->orderBy('created_at', 'desc')
            ->get();
    }

}
