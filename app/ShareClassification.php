<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareClassification extends Model
{
    //绑定表
    protected $table = 'share_classifications';


    public function shares()
    {
        return $this->hasMany('App\Share', 'id');
    }

}
