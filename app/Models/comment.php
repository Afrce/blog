<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    public function user()
    {
        return  $this->hasOne('App\User','id','user_id');
    }
    public function comment(){
        return $this->hasOne('App\Models\comment','comment_id','id');
    }
}
