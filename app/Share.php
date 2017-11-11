<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    //绑定表
    protected $table='shares';

    /**
     * 获取分享对应的用户
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
