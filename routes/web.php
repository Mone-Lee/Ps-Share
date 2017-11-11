<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test/welcome', function () {
    return view('welcome');
});

Route::get('webapp/login', function (){
    Auth::logout();
    Auth::loginUsingId(17);
    return view('login');
});


//Route::get('/home', function () {
//    return view('home');
//});

Auth::routes();

//Route::get('/home', 'HomeController@index');
//Route::post('/getPic', 'HomeController@getPic');


Route::get('/getCsrfToken', function () {
    return response()->json(csrf_token());
});


// 无需登录即可访问的请求
Route::group(['prefix' => 'home', 'namespace' => 'Home'], function () {
    // 返回视图
    Route::group(['prefix' => 'p', 'namespace' => 'P'], function () {
        Route::get('/index', ['as' => 'index', 'uses' => 'IndexController@index']);
        Route::get('/share-detail/{id}', ['as' => 'share-detail', 'uses' => 'IndexController@shareDetail']);
        Route::get('/share-list', ['as' => 'share-list', 'uses' => 'IndexController@shareList']);
    });

    // 接口
    Route::group(['prefix' => 'c', 'namespace' => 'C'], function () {

        // 获取所有分享分类
        Route::get('getAllClassification', 'IndexController@getAllClassification');
        // 首页获取所有分享，默认获取全部
        Route::get('getAllShares', 'IndexController@getAllShares');
        // 获取用户个人所有的分享分类
        Route::get('getAllUserClassification/{id}', 'IndexController@getAllUserClassification');
        // 首页查询或按分类获取分享，以及分页
        Route::get('queryShare', 'IndexController@queryShare');
        // 用户查询或按分类获取分享，以及分页
        Route::get('queryUserShare', 'IndexController@queryUserShare');
        // 获取用户详细个人信息
        Route::get('getUserMsg/{id}', 'IndexController@getUserMsg');
        // 用户空间的所有分享
        Route::get('getUserAllIndexShares/{id}', 'IndexController@getUserAllIndexShares');
        // 获取个人首页的所有信息：个人详细信息、关注、收藏、分享
        Route::get('getIndexUserMsg/{id}', 'IndexController@getIndexUserMsg');
        // 获取点赞榜（全部、最近一周、今天）
        Route::get('getLikesBoard', 'IndexController@getLikesBoard');
        // 获取用户的关注总数
        Route::get('getUserFollowNumbers/{id}', 'IndexController@getUserFollowNumbers');
        // 获取用户的分享总数
        Route::get('getUserShareNumber/{id}', 'IndexController@getUserShareNumber');
        // 获取用户的收藏总数
        Route::get('getUserCollectionNumber/{id}', 'IndexController@getUserCollectionNumber');
        // 获取所有举报分类
        Route::get('getAllReports', 'IndexController@getAllReports');


        // 获取分享发布者的信息
        Route::get('getShareUserMsg/{id}', 'ShareDetailController@getShareUserMsg');
        // 获取分享的详情：发布者信息、分享详情、点赞数、收藏数
        Route::get('getShareDetail/{id}', 'ShareDetailController@getShareDetail');
        // 获取分享详情页中的所有评论
        Route::get('getAllComments', 'ShareDetailController@getAllComments');
        // 获取对应评论下的所有回复
        Route::get('getAllCommentReplies', 'ShareDetailController@getAllCommentReplies');
        // 其他用户或游客访问的时候，获取所有关注分类
        Route::get('getAllFollwClassification/{userId}', 'NormalController@getAllFollwClassification');
        // 其他用户或游客访问的时候，获取所有收藏分类
        Route::get('getAllCollectionClassification/{userId}', 'NormalController@getAllCollectionClassification');
        // 其他用户或游客访问的时候，根据关注分类获取此分类下的所有关注者，分页
        Route::get('getAllFollowsByClassification', 'NormalController@getAllFollowsByClassification');
        // 其他用户或游客访问的时候，根据收藏分类获取此分类下的所有收藏，分页
        Route::get('getAllCollectionsByClassification', 'NormalController@getAllCollectionsByClassification');

        // 举报分享
        Route::get('reportShare', 'UserController@reportShare');
        // 举报评论
        Route::get('reportComment', 'UserController@reportComment');

    });
});

// 需要登录才能访问的请求，且认证用户必须没被冻结
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'active']], function () {
    // 返回视图
    Route::group(['prefix' => 'p', 'namespace' => 'P'], function () {
        Route::get('/admin-manage', ['middleware' => 'admin-manage', 'as' => 'index', 'uses' => 'AdminController@adminManage']);
        Route::get('/user-index/{id}', ['as' => 'share-detail', 'uses' => 'AdminController@userIndex']);
        Route::get('/user-manage', ['as' => 'share-list', 'uses' => 'AdminController@userManage']);
    });

    // 接口
    Route::group(['prefix' => 'c', 'namespace' => 'C'], function () {

        // 分享接口
        Route::get('share/indexAdmin', 'ShareController@indexAdmin');
        Route::get('share/query', 'ShareController@query');
        Route::delete('share/batch-delete', 'ShareController@batchDestroy');
        Route::resource('share', 'ShareController');
        // 获取个人后台管理页面的所有分享
        Route::get('indexAdmin', 'ShareController@indexAdmin');
        // 屏蔽或发布分享
        Route::get('triggleShare/{id}', 'ShareController@triggleShare');

        // 关注分类接口
        // 隐藏或显示分类
        Route::get('followClassification/triggle/{id}', 'FollowClassificationController@triggle');
        Route::resource('followClassification', 'FollowClassificationController');

        // 收藏分类接口
        // 隐藏或显示分类
        Route::get('collectionClassification/triggle/{id}', 'CollectionClassificationController@triggle');
        Route::resource('collectionClassification', 'CollectionClassificationController');

        // 关注接口
        // 移动关注到新分类
        Route::get('follow/move', 'FollowController@move');
        // 复制关注到新分类
        Route::get('follow/copy', 'FollowController@copy');
        Route::resource('follow', 'FollowController');


        // 点赞接口
        Route::resource('like', 'LikeController');

        // 收藏接口
        // 移动收藏到新分类
        Route::get('collection/move', 'CollectionController@move');
        // 复制收藏到新分类
        Route::get('collection/copy', 'CollectionController@copy');
        Route::resource('collection', 'CollectionController');


        // 评论接口
        Route::resource('comment', 'CommentController');

        // 用户相关接口
        // 获取用户基本信息
        Route::get('getUserMsg', 'UserController@getUserMsg');
        // 修改用户基本信息
        Route::post('saveUserMsg', 'UserController@saveUserMsg');
        // 更新密码
        Route::post('changePassword', 'UserController@changePassword');

        // 获取用户所有收到的评论和回复
        Route::get('getUserAllComments', 'NormalController@getUserAllComments');
        // 获取所有点过赞的分享
        Route::get('getAllLikedShare', 'NormalController@getAllLikedShare');
        // 获取所有评论过的分享
        Route::get('getAllCommentedShare', 'NormalController@getAllCommentedShare');
        // 获取所有的分享分类
        Route::get('getAllShareClassifications', 'NormalController@getAllShareClassifications');
        // 获取用户所有收到的赞
        Route::get('getAllLikes', 'NormalController@getAllLikes');


        //============================管理员功能==============================


        Route::group(['middleware' => ['admin-manage']], function () {
            // 分享的分类管理接口
            Route::delete('shareclassification/batch-delete', 'ShareClassificationController@batchDestroy');
            Route::resource('shareclassification', 'ShareClassificationController');

            // 关键字接口
            // 批量删除
            Route::delete('keyword/batch-delete', 'KeywordController@batchDestroy');
            // 查询
            Route::get('keyword/query', 'KeywordController@query');
            Route::resource('keyword', 'KeywordController');

            // 举报分类接口
            // 批量删除
            Route::delete('reportclassification/batch-delete', 'ReportClassificationController@batchDestroy');
            Route::resource('reportclassification', 'ReportClassificationController');
            // 举报分享接口
            // 屏蔽或解除屏蔽
            Route::post('sharereport/triggle', 'ShareReportController@triggle');
            Route::resource('sharereport', 'ShareReportController');
            // 举报评论接口
            // 忽略或解除忽略
            Route::post('commentreport/triggle', 'CommentReportController@triggle');
            Route::resource('commentreport', 'CommentReportController');

            // 获取所有用户，包括按搜索条件获取，按状态获取
            Route::get('getAllUser', 'AdminController@getAllUser');
            // 冻结或解冻用户
            Route::get('triggleUser/{id}', 'AdminController@triggleUser');
            // 批量冻结
            Route::get('batchLock', 'AdminController@batchLock');
            // 批量解冻
            Route::get('batchUnlock', 'AdminController@batchUnlock');
        });


        Route::group(['middleware' => 'admin'], function () {
            // 获取所有角色，不分页
            Route::get('rbac/getAllRoles', 'RBACController@getAllRoles');
            // 获取所有权限
            Route::get('rbac/getAllPermission', 'RBACController@getAllPermission');
            // 按name获取权限
            Route::get('rbac/getPermissionByName/{name}', 'RBACController@getPermissionByName');
            // 按权限分类获取所有权限
            Route::get('rbac/getPermissionByClassification', 'RBACController@getPermissionByClassification');
            // 角色权限接口
            //获取用户所拥有的所有的角色的id
            Route::get('rbac/getUserRole/{id}', 'RBACController@getUserRole');
            Route::post('rbac/userBindRole', 'RBACController@userBindRole');
            Route::resource('rbac', 'RBACController');
        });


    });
});




