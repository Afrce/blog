<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    public function Type(){
        return $this->hasOne('App\Models\type','id','type');
    }
}
