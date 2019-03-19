<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rate extends Model
{
    protected $table = 'rates';
    // primary key
    //public $primaryKey = ['id_user','id_book'];
    // timestamps
    public $timestamps = true;
    
    public function user(){
        return $this->belingsTo('App\User');
    }

    public function book(){
        return $this->hasOne('App\book');
    }
}
