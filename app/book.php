<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    protected $table = 'books';
    // primary key
    public $primaryKey = 'book_id';
    // timestamps
    public $timestamps = true;

    public function rate(){
        return $this->belingsTo('App\rate');
    }
}
