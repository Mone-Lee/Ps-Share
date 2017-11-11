<?php

use App\Permission;
use App\PermissionClassification;
use App\PPClassification;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //=======================新增权限分类===========================
        $adminManage = new PermissionClassification();
        $adminManage->name = '管理员权限';
        $adminManage->save();

        $shareClassification = new PermissionClassification();
        $shareClassification->name = '分享分类权限';
        $shareClassification->save();

        $keyword = new PermissionClassification();
        $keyword->name = '关键字权限';
        $keyword->save();

        $reportClassification = new PermissionClassification();
        $reportClassification->name = '举报分类权限';
        $reportClassification->save();

        $report = new PermissionClassification();
        $report->name = '举报权限';
        $report->save();

        $user = new PermissionClassification();
        $user->name = '用户权限';
        $user->save();

        $share = new PermissionClassification();
        $share->name = '分享权限';
        $share->save();

        $followClassification = new PermissionClassification();
        $followClassification->name = '关注分类权限';
        $followClassification->save();

        $collectionClassification = new PermissionClassification();
        $collectionClassification->name = '收藏分类权限';
        $collectionClassification->save();

        $follow = new PermissionClassification();
        $follow->name = '关注权限';
        $follow->save();

        $collection = new PermissionClassification();
        $collection->name = '收藏权限';
        $collection->save();

        $like = new PermissionClassification();
        $like->name = '点赞权限';
        $like->save();

        $comment = new PermissionClassification();
        $comment->name = '评论权限';
        $comment->save();

        //=======================管理员管理===========================
        $adminManageGetIn = new Permission();
        $adminManageGetIn->name = 'adminManage-getIn';
        $adminManageGetIn->display_name = '进入后台管理';
        $adminManageGetIn->description = '进入管理员后台管理页面的权限';
        $adminManageGetIn->save();

        $pp = new PPClassification();
        $pp->permission_id = $adminManageGetIn->id;
        $pp->permission_classification_id = $adminManage->id;
        $pp->save();

        //=======================分类管理===========================

        $shareClassificationAdd = new Permission();
        $shareClassificationAdd->name = 'shareClassification-add';
        $shareClassificationAdd->display_name = '新增分类';
        $shareClassificationAdd->description = '新增分类的权限';
        $shareClassificationAdd->save();

        $pp = new PPClassification();
        $pp->permission_id = $shareClassificationAdd->id;
        $pp->permission_classification_id = $shareClassification->id;
        $pp->save();

        $shareClassificationDelete = new Permission();
        $shareClassificationDelete->name = 'shareClassification-delete';
        $shareClassificationDelete->display_name = '删除单个分类';
        $shareClassificationDelete->description = '删除单个分类的权限';
        $shareClassificationDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $shareClassificationDelete->id;
        $pp->permission_classification_id = $shareClassification->id;
        $pp->save();

        $shareClassificationBatchDelete = new Permission();
        $shareClassificationBatchDelete->name = 'shareClassification-batchDelete';
        $shareClassificationBatchDelete->display_name = '批量删除分类';
        $shareClassificationBatchDelete->description = '批量删除分类的权限';
        $shareClassificationBatchDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $shareClassificationBatchDelete->id;
        $pp->permission_classification_id = $shareClassification->id;
        $pp->save();

        $shareClassificationEdit = new Permission();
        $shareClassificationEdit->name = 'shareClassification-edit';
        $shareClassificationEdit->display_name = '编辑分类';
        $shareClassificationEdit->description = '编辑分类的权限';
        $shareClassificationEdit->save();

        $pp = new PPClassification();
        $pp->permission_id = $shareClassificationEdit->id;
        $pp->permission_classification_id = $shareClassification->id;
        $pp->save();

        $shareClassificationQuery = new Permission();
        $shareClassificationQuery->name = 'shareClassification-query';
        $shareClassificationQuery->display_name = '查询分类';
        $shareClassificationQuery->description = '查询分类的权限';
        $shareClassificationQuery->save();

        $pp = new PPClassification();
        $pp->permission_id = $shareClassificationQuery->id;
        $pp->permission_classification_id = $shareClassification->id;
        $pp->save();


        //=======================关键字管理===========================

        $keywordAdd = new Permission();
        $keywordAdd->name = 'keyword-add';
        $keywordAdd->display_name = '新增关键字';
        $keywordAdd->description = '新增关键字的权限';
        $keywordAdd->save();

        $pp = new PPClassification();
        $pp->permission_id = $keywordAdd->id;
        $pp->permission_classification_id = $keyword->id;
        $pp->save();

        $keywordDelete = new Permission();
        $keywordDelete->name = 'keyword-delete';
        $keywordDelete->display_name = '删除单个关键字';
        $keywordDelete->description = '删除单个关键字的权限';
        $keywordDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $keywordDelete->id;
        $pp->permission_classification_id = $keyword->id;
        $pp->save();

        $keywordBatchDelete = new Permission();
        $keywordBatchDelete->name = 'keyword-batchDelete';
        $keywordBatchDelete->display_name = '批量删除关键字';
        $keywordBatchDelete->description = '批量删除关键字的权限';
        $keywordBatchDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $keywordBatchDelete->id;
        $pp->permission_classification_id = $keyword->id;
        $pp->save();

        $keywordEdit = new Permission();
        $keywordEdit->name = 'keyword-edit';
        $keywordEdit->display_name = '编辑关键字';
        $keywordEdit->description = '编辑关键字的权限';
        $keywordEdit->save();

        $pp = new PPClassification();
        $pp->permission_id = $keywordEdit->id;
        $pp->permission_classification_id = $keyword->id;
        $pp->save();

        $keywordQuery = new Permission();
        $keywordQuery->name = 'keyword-query';
        $keywordQuery->display_name = '查询关键字';
        $keywordQuery->description = '查询关键字的权限';
        $keywordQuery->save();

        $pp = new PPClassification();
        $pp->permission_id = $keywordQuery->id;
        $pp->permission_classification_id = $keyword->id;
        $pp->save();

        //=======================举报分类管理===========================

        $reportClassificationAdd = new Permission();
        $reportClassificationAdd->name = 'reportClassification-add';
        $reportClassificationAdd->display_name = '新增举报分类';
        $reportClassificationAdd->description = '新增举报分类的权限';
        $reportClassificationAdd->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportClassificationAdd->id;
        $pp->permission_classification_id = $reportClassification->id;
        $pp->save();

        $reportClassificationDelete = new Permission();
        $reportClassificationDelete->name = 'reportClassification-delete';
        $reportClassificationDelete->display_name = '删除单个举报分类';
        $reportClassificationDelete->description = '删除单个举报分类的权限';
        $reportClassificationDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportClassificationDelete->id;
        $pp->permission_classification_id = $reportClassification->id;
        $pp->save();

        $reportClassificationBatchDelete = new Permission();
        $reportClassificationBatchDelete->name = 'reportClassification-batchDelete';
        $reportClassificationBatchDelete->display_name = '批量删除举报分类';
        $reportClassificationBatchDelete->description = '批量删除举报分类的权限';
        $reportClassificationBatchDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportClassificationBatchDelete->id;
        $pp->permission_classification_id = $reportClassification->id;
        $pp->save();

        $reportClassificationEdit = new Permission();
        $reportClassificationEdit->name = 'reportClassification-edit';
        $reportClassificationEdit->display_name = '编辑举报分类';
        $reportClassificationEdit->description = '编辑举报分类的权限';
        $reportClassificationEdit->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportClassificationEdit->id;
        $pp->permission_classification_id = $reportClassification->id;
        $pp->save();

        $reportClassificationQuery = new Permission();
        $reportClassificationQuery->name = 'reportClassification-query';
        $reportClassificationQuery->display_name = '查询举报分类';
        $reportClassificationQuery->description = '查询举报分类的权限';
        $reportClassificationQuery->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportClassificationQuery->id;
        $pp->permission_classification_id = $reportClassification->id;
        $pp->save();

        //=======================举报管理===========================

        $reportShareIndex = new Permission();
        $reportShareIndex->name = 'report-share-index';
        $reportShareIndex->display_name = '获取分享举报';
        $reportShareIndex->description = '获取分享举报的权限';
        $reportShareIndex->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportShareIndex->id;
        $pp->permission_classification_id = $report->id;
        $pp->save();

        $reportShareMore = new Permission();
        $reportShareMore->name = 'report-share-more';
        $reportShareMore->display_name = '更多分享举报';
        $reportShareMore->description = '获取更多分享举报的权限';
        $reportShareMore->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportShareMore->id;
        $pp->permission_classification_id = $report->id;
        $pp->save();

        $reportShareTriggle = new Permission();
        $reportShareTriggle->name = 'report-share-triggle';
        $reportShareTriggle->display_name = '屏蔽/解除屏蔽举报';
        $reportShareTriggle->description = '屏蔽/解除屏蔽举报的权限';
        $reportShareTriggle->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportShareTriggle->id;
        $pp->permission_classification_id = $report->id;
        $pp->save();

        $reportShareDelete = new Permission();
        $reportShareDelete->name = 'report-share-triggle';
        $reportShareDelete->display_name = '删除分享和举报';
        $reportShareDelete->description = '删除分享和举报的权限';
        $reportShareDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportShareDelete->id;
        $pp->permission_classification_id = $report->id;
        $pp->save();

        $reportCommentIndex = new Permission();
        $reportCommentIndex->name = 'report-comment-index';
        $reportCommentIndex->display_name = '获取评论举报';
        $reportCommentIndex->description = '获取评论举报的权限';
        $reportCommentIndex->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportCommentIndex->id;
        $pp->permission_classification_id = $report->id;
        $pp->save();

        $reportCommentMore = new Permission();
        $reportCommentMore->name = 'report-comment-more';
        $reportCommentMore->display_name = '更多评论举报';
        $reportCommentMore->description = '获取更多评论举报的权限';
        $reportCommentMore->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportCommentMore->id;
        $pp->permission_classification_id = $report->id;
        $pp->save();

        $reportCommentTriggle = new Permission();
        $reportCommentTriggle->name = 'report-comment-triggle';
        $reportCommentTriggle->display_name = '忽略/解除忽略举报';
        $reportCommentTriggle->description = '忽略/解除忽略举报的权限';
        $reportCommentTriggle->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportCommentTriggle->id;
        $pp->permission_classification_id = $report->id;
        $pp->save();

        $reportCommentDelete = new Permission();
        $reportCommentDelete->name = 'report-comment-triggle';
        $reportCommentDelete->display_name = '删除评论和举报';
        $reportCommentDelete->description = '删除评论和举报的权限';
        $reportCommentDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportCommentDelete->id;
        $pp->permission_classification_id = $report->id;
        $pp->save();
        

        //=======================用户管理===========================

        $userLock = new Permission();
        $userLock->name = 'user-lock';
        $userLock->display_name = '冻结/解冻用户';
        $userLock->description = '冻结/解冻用户的权限';
        $userLock->save();

        $pp = new PPClassification();
        $pp->permission_id = $userLock->id;
        $pp->permission_classification_id = $user->id;
        $pp->save();

        //=======================分享管理===========================

        $shareAdd = new Permission();
        $shareAdd->name = 'share-add';
        $shareAdd->display_name = '新增分享';
        $shareAdd->description = '新增分享的权限';
        $shareAdd->save();

        $pp = new PPClassification();
        $pp->permission_id = $shareAdd->id;
        $pp->permission_classification_id = $share->id;
        $pp->save();

        $shareDelete = new Permission();
        $shareDelete->name = 'share-delete';
        $shareDelete->display_name = '删除单个分享';
        $shareDelete->description = '删除单个分享的权限';
        $shareDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $shareDelete->id;
        $pp->permission_classification_id = $share->id;
        $pp->save();

        $shareBatchDelete = new Permission();
        $shareBatchDelete->name = 'share-batchDelete';
        $shareBatchDelete->display_name = '批量删除分享';
        $shareBatchDelete->description = '批量删除分享的权限';
        $shareBatchDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $shareBatchDelete->id;
        $pp->permission_classification_id = $share->id;
        $pp->save();

        $shareQuery = new Permission();
        $shareQuery->name = 'share-query';
        $shareQuery->display_name = '查询分享';
        $shareQuery->description = '查询分享的权限';
        $shareQuery->save();

        $pp = new PPClassification();
        $pp->permission_id = $shareQuery->id;
        $pp->permission_classification_id = $share->id;
        $pp->save();

        $shareTriggle = new Permission();
        $shareTriggle->name = 'share-triggle';
        $shareTriggle->display_name = '屏蔽或发布分享';
        $shareTriggle->description = '屏蔽或发布分享的权限';
        $shareTriggle->save();

        $pp = new PPClassification();
        $pp->permission_id = $shareTriggle->id;
        $pp->permission_classification_id = $share->id;
        $pp->save();

        //=======================关注分类管理===========================

        $followClassificationGetAll = new Permission();
        $followClassificationGetAll->name = 'followClassification-get-all';
        $followClassificationGetAll->display_name = '获取所有关注分类';
        $followClassificationGetAll->description = '获取所有关注分类的权限';
        $followClassificationGetAll->save();

        $pp = new PPClassification();
        $pp->permission_id = $followClassificationGetAll->id;
        $pp->permission_classification_id = $followClassification->id;
        $pp->save();

        $followClassificationAdd = new Permission();
        $followClassificationAdd->name = 'followClassification-add';
        $followClassificationAdd->display_name = '新增关注分类';
        $followClassificationAdd->description = '新增关注分类的权限';
        $followClassificationAdd->save();

        $pp = new PPClassification();
        $pp->permission_id = $followClassificationAdd->id;
        $pp->permission_classification_id = $followClassification->id;
        $pp->save();
        
        $followClassificationEdit = new Permission();
        $followClassificationEdit->name = 'followClassification-edit';
        $followClassificationEdit->display_name = '编辑关注分类';
        $followClassificationEdit->description = '编辑关注分类的权限';
        $followClassificationEdit->save();

        $pp = new PPClassification();
        $pp->permission_id = $followClassificationEdit->id;
        $pp->permission_classification_id = $followClassification->id;
        $pp->save();

        $followClassificationDelete = new Permission();
        $followClassificationDelete->name = 'followClassification-delete';
        $followClassificationDelete->display_name = '删除单个关注分类';
        $followClassificationDelete->description = '删除单个关注分类的权限';
        $followClassificationDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $followClassificationDelete->id;
        $pp->permission_classification_id = $followClassification->id;
        $pp->save();

        $followClassificationTriggle = new Permission();
        $followClassificationTriggle->name = 'followClassification-triggle';
        $followClassificationTriggle->display_name = '隐藏或显示关注分类';
        $followClassificationTriggle->description = '隐藏或显示关注分类的权限';
        $followClassificationTriggle->save();

        $pp = new PPClassification();
        $pp->permission_id = $followClassificationTriggle->id;
        $pp->permission_classification_id = $followClassification->id;
        $pp->save();

        //=======================收藏分类管理===========================

        $collectionClassificationGetAll = new Permission();
        $collectionClassificationGetAll->name = 'collectionClassification-get-all';
        $collectionClassificationGetAll->display_name = '获取所有收藏分类';
        $collectionClassificationGetAll->description = '获取所有收藏分类的权限';
        $collectionClassificationGetAll->save();

        $pp = new PPClassification();
        $pp->permission_id = $collectionClassificationGetAll->id;
        $pp->permission_classification_id = $collectionClassification->id;
        $pp->save();

        $collectionClassificationAdd = new Permission();
        $collectionClassificationAdd->name = 'collectionClassification-add';
        $collectionClassificationAdd->display_name = '新增收藏分类';
        $collectionClassificationAdd->description = '新增收藏分类的权限';
        $collectionClassificationAdd->save();

        $pp = new PPClassification();
        $pp->permission_id = $collectionClassificationAdd->id;
        $pp->permission_classification_id = $collectionClassification->id;
        $pp->save();

        $collectionClassificationEdit = new Permission();
        $collectionClassificationEdit->name = 'collectionClassification-edit';
        $collectionClassificationEdit->display_name = '编辑收藏分类';
        $collectionClassificationEdit->description = '编辑收藏分类的权限';
        $collectionClassificationEdit->save();

        $pp = new PPClassification();
        $pp->permission_id = $collectionClassificationEdit->id;
        $pp->permission_classification_id = $collectionClassification->id;
        $pp->save();

        $collectionClassificationDelete = new Permission();
        $collectionClassificationDelete->name = 'collectionClassification-delete';
        $collectionClassificationDelete->display_name = '删除单个收藏分类';
        $collectionClassificationDelete->description = '删除单个收藏分类的权限';
        $collectionClassificationDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $collectionClassificationDelete->id;
        $pp->permission_classification_id = $collectionClassification->id;
        $pp->save();

        $collectionClassificationTriggle = new Permission();
        $collectionClassificationTriggle->name = 'collectionClassification-triggle';
        $collectionClassificationTriggle->display_name = '隐藏或显示收藏分类';
        $collectionClassificationTriggle->description = '隐藏或显示收藏分类的权限';
        $collectionClassificationTriggle->save();

        $pp = new PPClassification();
        $pp->permission_id = $collectionClassificationTriggle->id;
        $pp->permission_classification_id = $collectionClassification->id;
        $pp->save();

        //=======================关注管理===========================

        $followFollow = new Permission();
        $followFollow->name = 'follow-follow';
        $followFollow->display_name = '关注用户';
        $followFollow->description = '关注用户的权限';
        $followFollow->save();

        $pp = new PPClassification();
        $pp->permission_id = $followFollow->id;
        $pp->permission_classification_id = $follow->id;
        $pp->save();

        $followUnfollow = new Permission();
        $followUnfollow->name = 'follow-unfollow';
        $followUnfollow->display_name = '取消关注用户';
        $followUnfollow->description = '取消关注用户的权限';
        $followUnfollow->save();

        $pp = new PPClassification();
        $pp->permission_id = $followUnfollow->id;
        $pp->permission_classification_id = $follow->id;
        $pp->save();

        $followMove = new Permission();
        $followMove->name = 'follow-move';
        $followMove->display_name = '移动关注用户到其他分类';
        $followMove->description = '移动关注用户到其他分类的权限';
        $followMove->save();

        $pp = new PPClassification();
        $pp->permission_id = $followMove->id;
        $pp->permission_classification_id = $follow->id;
        $pp->save();

        $followCopy = new Permission();
        $followCopy->name = 'follow-copy';
        $followCopy->display_name = '复制关注用户到其他分类';
        $followCopy->description = '复制关注用户到其他分类的权限';
        $followCopy->save();

        $pp = new PPClassification();
        $pp->permission_id = $followCopy->id;
        $pp->permission_classification_id = $follow->id;
        $pp->save();

        //=======================收藏管理===========================

        $collectionCollect = new Permission();
        $collectionCollect->name = 'collection-collect';
        $collectionCollect->display_name = '收藏分享';
        $collectionCollect->description = '收藏分享的权限';
        $collectionCollect->save();

        $pp = new PPClassification();
        $pp->permission_id = $collectionCollect->id;
        $pp->permission_classification_id = $collection->id;
        $pp->save();

        $collectionUncollec = new Permission();
        $collectionUncollec->name = 'collection-uncollect';
        $collectionUncollec->display_name = '取消收藏分享';
        $collectionUncollec->description = '取消收藏分享的权限';
        $collectionUncollec->save();

        $pp = new PPClassification();
        $pp->permission_id = $collectionUncollec->id;
        $pp->permission_classification_id = $collection->id;
        $pp->save();

        $collectionMove = new Permission();
        $collectionMove->name = 'collection-move';
        $collectionMove->display_name = '移动收藏分享到其他分类';
        $collectionMove->description = '移动收藏分享到其他分类的权限';
        $collectionMove->save();

        $pp = new PPClassification();
        $pp->permission_id = $collectionMove->id;
        $pp->permission_classification_id = $collection->id;
        $pp->save();

        $collectionCopy = new Permission();
        $collectionCopy->name = 'collection-copy';
        $collectionCopy->display_name = '复制收藏分享到其他分类';
        $collectionCopy->description = '复制收藏分享到其他分类的权限';
        $collectionCopy->save();

        $pp = new PPClassification();
        $pp->permission_id = $collectionCopy->id;
        $pp->permission_classification_id = $collection->id;
        $pp->save();

        //=======================点赞功能===========================

        $likeLike = new Permission();
        $likeLike->name = 'like-like';
        $likeLike->display_name = '点赞';
        $likeLike->description = '点赞的权限';
        $likeLike->save();

        $pp = new PPClassification();
        $pp->permission_id = $likeLike->id;
        $pp->permission_classification_id = $like->id;
        $pp->save();

        $likeUnlike = new Permission();
        $likeUnlike->name = 'like-unlike';
        $likeUnlike->display_name = '取消点赞';
        $likeUnlike->description = '取消点赞的权限';
        $likeUnlike->save();

        $pp = new PPClassification();
        $pp->permission_id = $likeUnlike->id;
        $pp->permission_classification_id = $like->id;
        $pp->save();

        //=======================评论功能===========================

        $commentComment = new Permission();
        $commentComment->name = 'comment-comment';
        $commentComment->display_name = '评论';
        $commentComment->description = '评论的权限';
        $commentComment->save();

        $pp = new PPClassification();
        $pp->permission_id = $commentComment->id;
        $pp->permission_classification_id = $comment->id;
        $pp->save();

        $commentCommentReply = new Permission();
        $commentCommentReply->name = 'comment-commentReply';
        $commentCommentReply->display_name = '回复评论';
        $commentCommentReply->description = '回复评论的权限';
        $commentCommentReply->save();

        $pp = new PPClassification();
        $pp->permission_id = $commentCommentReply->id;
        $pp->permission_classification_id = $comment->id;
        $pp->save();
    }
}
