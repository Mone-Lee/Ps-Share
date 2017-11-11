<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ------------------------admin---------------------------

        $admin = new \App\User();
        $admin->name = 'admin';
        $admin->email = 'admin@qq.com';
        $admin->password = bcrypt('123456');
        $admin->save();
        
        $adminUserMessage = new \App\UserMessage();
        $adminUserMessage->pic = 'images/default.png';
        $adminUserMessage->sex = 1;
        $adminUserMessage->introduction = 'hello!'.$admin->name;
        $adminUserMessage->user_id = $admin->id;
        $adminUserMessage->save();

        $adminFollowClassification = new \App\FollowClassification();
        $adminFollowClassification->name = '默认';
        $adminFollowClassification->user_id = $admin->id;
        $adminFollowClassification->save();

        $collectionFollowClassification = new \App\CollectionClassification();
        $collectionFollowClassification->name = '默认';
        $collectionFollowClassification->user_id = $admin->id;
        $collectionFollowClassification->save();

        // -------------------------rigar--------------------------

        $rigar = new \App\User();
        $rigar->name = 'rigar';
        $rigar->email = 'rigar@qq.com';
        $rigar->password = bcrypt('123456');
        $rigar->save();

        $rigarUserMessage = new \App\UserMessage();
        $rigarUserMessage->pic = 'images/default.png';
        $rigarUserMessage->sex = 1;
        $rigarUserMessage->introduction = 'hello!'.$rigar->name;
        $rigarUserMessage->user_id = $rigar->id;
        $rigarUserMessage->save();

        $rigarFollowClassification = new \App\FollowClassification();
        $rigarFollowClassification->name = '默认';
        $rigarFollowClassification->user_id = $rigar->id;
        $rigarFollowClassification->save();

        $collectionFollowClassification = new \App\CollectionClassification();
        $collectionFollowClassification->name = '默认';
        $collectionFollowClassification->user_id = $rigar->id;
        $collectionFollowClassification->save();

        // -----------------------zxm----------------------------

        $zxm = new \App\User();
        $zxm->name = 'zxm';
        $zxm->email = 'zxm@qq.com';
        $zxm->password = bcrypt('123456');
        $zxm->save();

        $zxmUserMessage = new \App\UserMessage();
        $zxmUserMessage->pic = 'images/default.png';
        $zxmUserMessage->sex = 1;
        $zxmUserMessage->introduction = 'hello!'.$zxm->name;
        $zxmUserMessage->user_id = $zxm->id;
        $zxmUserMessage->save();

        $zxmFollowClassification = new \App\FollowClassification();
        $zxmFollowClassification->name = '默认';
        $zxmFollowClassification->user_id = $zxm->id;
        $zxmFollowClassification->save();

        $collectionFollowClassification = new \App\CollectionClassification();
        $collectionFollowClassification->name = '默认';
        $collectionFollowClassification->user_id = $zxm->id;
        $collectionFollowClassification->save();

        // ---------------------ycm------------------------------

        $ycm = new \App\User();
        $ycm->name = 'ycm';
        $ycm->email = 'ycm@qq.com';
        $ycm->password = bcrypt('123456');
        $ycm->save();

        $ycmUserMessage = new \App\UserMessage();
        $ycmUserMessage->pic = 'images/default.png';
        $ycmUserMessage->sex = 1;
        $ycmUserMessage->introduction = 'hello!'.$ycm->name;
        $ycmUserMessage->user_id = $ycm->id;
        $ycmUserMessage->save();

        $ycmFollowClassification = new \App\FollowClassification();
        $ycmFollowClassification->name = '默认';
        $ycmFollowClassification->user_id = $ycm->id;
        $ycmFollowClassification->save();

        $collectionFollowClassification = new \App\CollectionClassification();
        $collectionFollowClassification->name = '默认';
        $collectionFollowClassification->user_id = $ycm->id;
        $collectionFollowClassification->save();

        // ---------------------lmy-----------------------------

        $lmy = new \App\User();
        $lmy->name = 'lmy';
        $lmy->email = 'lmy@qq.com';
        $lmy->password = bcrypt('123456');
        $lmy->save();

        $lmyUserMessage = new \App\UserMessage();
        $lmyUserMessage->pic = 'images/default.png';
        $lmyUserMessage->sex = 1;
        $lmyUserMessage->introduction = 'hello!'.$lmy->name;
        $lmyUserMessage->user_id = $lmy->id;
        $lmyUserMessage->save();

        $lmyFollowClassification = new \App\FollowClassification();
        $lmyFollowClassification->name = '默认';
        $lmyFollowClassification->user_id = $lmy->id;
        $lmyFollowClassification->save();

        $collectionFollowClassification = new \App\CollectionClassification();
        $collectionFollowClassification->name = '默认';
        $collectionFollowClassification->user_id = $lmy->id;
        $collectionFollowClassification->save();

    }
}
