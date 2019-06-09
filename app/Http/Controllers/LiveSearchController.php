<?php

namespace App\Http\Controllers;
use App\book;
use Illuminate\Http\Request;
use DB;

class LiveSearchController extends Controller
{
    function index(Request $request){
      $books = [];
      if( $request->input('query') != "" )
        {
          $books = book::where('title', 'LIKE' , '%'. $request->get('query') . '%' )
          ->orWhere('authors', 'LIKE' , '%'. $request->get('query') . '%')
          ->paginate(8)
          ->get();

        }else
        {
          $books = book::paginate(8);
        }
      //return view('\liveSearch')->with('books',$books);
      return view('\liveSearch' , ['books' => $books]);
    }

    function indexForm(Request $request){
      $books = [];
      
      if( $request->input('query') != "" )
        {
          // $books = book::where('title', 'LIKE' , '%'. $request->get('query') . '%' )
          // ->orWhere('authors', 'LIKE' , '%'. $request->get('query') . '%')
          // ->paginate(10)
          $books=book::where(function($q) use ($request) {
            $q->where('title', 'LIKE' , '%'. $request->get('query') . '%')
            ->orWhere('authors', 'LIKE' , '%'. $request->get('query') . '%');
          })->paginate(8);

        }else
        {
          $books = book::paginate(10);
        }
      //return view('\liveSearch')->with('books',$books);
      return view('\liveSearch' , ['books' => $books]);
    }
    
    
   
}
?>
