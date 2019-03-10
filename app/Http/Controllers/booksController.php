<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\book;
use App\User;
use App\user_rate;

class booksController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    

    public function index()
    {
        $books = book::orderBy('average_rating','desc')->paginate(8);
        return view('books.index')->with('books',$books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[
            'title'=>'required',
            'isbn'=>'required',
            'authors'=>'required',
            'original_publication_year'=>'required',
            'language_code'=>'required',
            'image_url'=>'image|nullable|max:1999'
        ]);
        if($request->hasFile('image_url')){
            //getfilename with extention
            $filenameWithExt = $request->file('image_url')->getClientOriginalName();
            // get just file name 
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // get just ext
            $extention = $request->file('image_url')->getClientOriginalExtension();
            //filename to store 
            $fileNameToStore= $filename.'_'.time().'.'.$extention;
            // upload image
            $path=$request->file('image_url')->storeAs('public/image_urls',$fileNameToStore);
        }
        else{
            $fileNameToStore='noimage.jpg';
        }
        
        $book = new Book;
        $book->title = $request->input('title');
        $book->isbn = $request->input('isbn');
        $book->authors = $request->input('authors');
        $book->original_publication_year = $request->input('original_publication_year');
        $book->language_code = $request->input('language_code');
        $book->average_rating = 0;
        $book->work_ratings_count = 0;
        $book->ratings_1 = 0;
        $book->ratings_2 = 0;
        $book->ratings_3 = 0;
        $book->ratings_4 = 0;
        $book->ratings_5 = 0;
        $book->image_url=$fileNameToStore;
        $book->save();
        return redirect('\books')->with('success','book created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $book= book::find($id);
       return view('books.show')->with('book',$book);
    }    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book= book::find($id);
        if(auth()->user()->id !== 1){
            return redirect('/books')->with('error','unauthorized page');
        }
        return view('books.edit')->with('book',$book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
 
        $this->validate($request,[
            'title'=>'required',
            'isbn'=>'required',
            'authors'=>'required',
            'original_publication_year'=>'required',
            'language_code'=>'required',
            'image_url'=>'image|nullable|max:1999'
        ]);
        
        $book = book::find($id);
        $book->title = $request->input('title');
        $book->isbn = $request->input('isbn');
        $book->authors = $request->input('authors');
        $book->original_publication_year = $request->input('original_publication_year');
        $book->language_code = $request->input('language_code');
        $book->save();
        return redirect('\books')->with('success','book Updated');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = book::find($id);
        if(auth()->user()->id !== 1){
            return redirect('/books')->with('error','unauthorized page');
        }
        $book->delete();
        return redirect('\books')->with('success','Book Removed');
    }

    /*
     * 
     * the Rate Function
     * 
     */


 
    public function rate(Request $request)
    {
 
        $this->validate($request,[
            'id_user'=>'required',
            'id_book'=>'required',
            'user_rate'=>'required'
        ]);

        $user_rate = new user_rate;
        $user_rate->id_user = $request->input('id_user');
        $user_rate->id_book = $request->input('id_book');
        $user_rate->user_rate = $request->input('user_rate');

        $book = book::find($user_rate->id_book);
        $book->work_ratings_count = $book->work_ratings_count + 1;
            if($user_rate->user_rate=='5'){$book->ratings_5 = $book->ratings_5 + 1;}
        elseif($user_rate->user_rate=='4'){$book->ratings_4 = $book->ratings_4 + 1;}
        elseif($user_rate->user_rate=='3'){$book->ratings_3 = $book->ratings_3 + 1;}
        elseif($user_rate->user_rate=='2'){$book->ratings_2 = $book->ratings_2 + 1;}
        elseif($user_rate->user_rate=='1'){$book->ratings_1 = $book->ratings_1 + 1;}
        

        $book->save();
        $user_rate->save();
        //return back();
        return redirect('\books')->with('success','Rated is saved');
        }
}
