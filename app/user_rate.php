<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fasades\Schema;


class user_rate extends Model
{
    //
    protected $table = 'book_rate';
    // primary key
    public $primaryKey = 'rate_id';
    // timestamps
    public $timestamps = true;
    
    public function user(){
        return $this->belingsTo('App\User');
    }
}
