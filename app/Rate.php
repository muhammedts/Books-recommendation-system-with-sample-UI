<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rate extends Model
{

    protected $table = 'rates';
    // primary key (['user_id', 'book_id'])
    public $primaryKey = ['user_id', 'book_id'];
    public $incrementing = false;   
    // timestamps
    public $timestamps = true;
    
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function book(){
        return $this->belongsTo('App\book');
    }
}
