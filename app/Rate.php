<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'book_rate';
    // primary key
    //public $primaryKey = ['id_user','id_book'];
    // timestamps
    public $timestamps = true;
    
    public function user(){
        return $this->belingsTo('App\User');
    }
}
