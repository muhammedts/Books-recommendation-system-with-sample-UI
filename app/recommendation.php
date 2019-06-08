<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class recommendation extends Model
{
    //
    protected $table = 'recommendations';
    public $primaryKey = 'userId';
    public $timestamps = true;
    
    public function user(){
        return $this->belongsTo('App\User' , 'userId');
    }
}

