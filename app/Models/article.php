<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    //类别
    public function Type(){
        return $this->hasOne('App\Models\type','id','type');
    }
    //收藏
    public  function Collection(){
        return $this->hasMany('App\Models\Collection','article_id','id');
    }
    //评论
    public function Comment(){
        return $this->hasMany('App\Models\comment','article_id','id');
    }

}
