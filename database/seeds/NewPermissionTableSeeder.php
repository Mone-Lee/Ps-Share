<?php

use App\Permission;
use App\PermissionClassification;
use App\PPClassification;
use Illuminate\Database\Seeder;

class NewPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //=======================新增权限分类===========================

        $reportClassification = new PermissionClassification();
        $reportClassification->name = '举报分类权限';
        $reportClassification->save();

        $report = new PermissionClassification();
        $report->name = '举报权限';
        $report->save();

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
        $reportShareDelete->name = 'report-share-delete';
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
        $reportCommentDelete->name = 'report-comment-delete';
        $reportCommentDelete->display_name = '删除评论和举报';
        $reportCommentDelete->description = '删除评论和举报的权限';
        $reportCommentDelete->save();

        $pp = new PPClassification();
        $pp->permission_id = $reportCommentDelete->id;
        $pp->permission_classification_id = $report->id;
        $pp->save();
   
    }
}
