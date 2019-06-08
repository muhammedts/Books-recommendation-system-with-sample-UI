<?php

namespace App\Http\Controllers;
use App\book;
use App\Review;
use Illuminate\Http\Request;
use DB;

class reviewController extends Controller

{
    public function index(Request $request){

        $this->validate($request,[
            'user_id'=>'required',
            'book_id'=>'required',
            'review'=>'required'
        ]);

        
        $review = new Review;
        $review->user_id = $request->input('user_id');
        $review->book_id = $request->input('book_id');
        $review->review = $request->input('review');
        
        try{$review->save();}
        catch (\Exception $e) {return redirect('books\\' . $request->input('book_id'))->with('error','Review has not Added');}

        return redirect('books\\' . $request->input('book_id'))->with('success','Review is Added');
    }
  
}

?>