<?php

/**
 * 存放不属于某一特定页面的接口
 */

namespace App\Http\Controllers\Home\C;

use App\CollectionClassification;
use App\FollowClassification;
use App\SharePicture;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class NormalController extends Controller
{
    /**
     * 其他用户或游客访问的时候，获取所有关注分类，附带被关注用户头像
     *
     * @param $userId
     * @return mixed
     */
    public function getAllFollwClassification($userId)
    {
        // 关注分类
        $followClassifications = FollowClassification::where('user_id', $userId)
            ->select('id', 'name', 'user_id')
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->get();
        $followClassificationList = array();
        foreach ($followClassifications as $followClassification) {
            $userPics = DB::table('users')
                ->join('follows', 'follows.followed_id', '=', 'users.id')
                ->join('user_messages', 'user_messages.user_id', '=', 'users.id')
                ->select(
                    'user_messages.pic',
                    'users.name'
                )
                ->where('follows.follow_classification_id', $followClassification->id)
                ->orderBy('follows.created_at', 'desc')
                ->take(4)// 只取前四个
                ->get();
            $item = null;
            $item['followClassification'] = $followClassification;
            $item['userPics'] = $userPics;
            array_push($followClassificationList, $item);
        }

        return $followClassificationList;
    }

    /**
     * 其他用户或游客访问的时候，获取所有收藏分类，附带被收藏的分享的第一张图片
     *
     * @param $userId
     * @return mixed
     */
    public function getAllCollectionClassification($userId)
    {
        $collectionClassifications = CollectionClassification::where('user_id', $userId)
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
     * 其他用户或游客访问的时候，根据关注分类获取此分类下的所有关注者，分页
     * @param Request $request
     * @return mixed
     */
    public function getAllFollowsByClassification(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required',
            'followClassificationId' => 'required'
        ]);

        // 关注者id
        $followerId = $request->input('userId');
        // 关注分类id
        $followClassificationId = $request->input('followClassificationId');

        $follows = DB::table('follows')
            ->join('users', 'users.id', '=', 'follows.followed_id')
            ->join('user_messages', 'user_messages.user_id', '=', 'follows.followed_id')
            ->join('follow_classifications', 'follow_classifications.id', '=', 'follows.follow_classification_id')
            ->select(
                'users.id as followed_id',
                'users.name as followed_name',
                'user_messages.introduction'
            )
            ->where('follows.follower_id', $followerId)
            ->where('follow_classifications.id', $followClassificationId)
            ->orderBy('follows.created_at', 'desc')
            ->paginate(config('app.page_size'));

        return $follows;
    }

    /**
     * 其他用户或游客访问的时候，根据收藏分类获取此分类下的所有收藏，分页
     * @param Request $request
     * @return mixed
     */
    public function getAllCollectionsByClassification(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required',
            'collectionClassificationId' => 'required'
        ]);

        // 收藏者id
        $followerId = $request->input('userId');
        // 收藏分类id
        $collectionClassificationId = $request->input('collectionClassificationId');

        $shares = DB::table('collections')
            ->join('shares', 'shares.id', '=', 'collections.share_id')
            ->join('collection_classifications', 'collection_classifications.id', '=', 'collections.collection_classification_id')
            ->select(
                'shares.user_id as user_id',        // 分享拥有者id
                'shares.id as share_id',            // 分享id
                'shares.content',                    // 分享内容
                'shares.abstract',                   // 分享摘要
                'shares.created_at'                  // 分享发布时间
            )
            ->where('collection_classifications.id', $collectionClassificationId)
            ->where('collection_classifications.user_id', $followerId)
            ->where('collections.user_id', $followerId)
            ->orderBy('collections.created_at', 'desc')
            ->paginate(config('app.page_size'));

        $shareList = array();
        foreach ($shares as $share) {
            $pictures = SharePicture::where('share_id', $share->share_id)
                ->orderBy('order', 'desc')
                ->select('id', 'path', 'order')->get();
            $shareOwner = User::find($share->user_id);
            if ($shareOwner != null) {
                $share->user_name = $shareOwner->name;
            } else {
                $share->user_name = '';
            }
            $item = null;
            $item['share'] = $share;
            $item['pictures'] = $pictures;
            array_push($shareList, $item);
        }

        $shareList = new LengthAwarePaginator($shareList, $total = $shares->total(), config('app.page_size'));

        return $shareList;
    }
}
