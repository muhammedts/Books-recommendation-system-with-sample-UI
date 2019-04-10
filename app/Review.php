<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    // primary key
    // timestamps
    public $timestamps = true;
    
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function book(){
        return $this->belongsTo('App\book');
    }
}
