<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\book;
use App\Rate;
use App\User;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $books =  array('book');
        /*$rates = Rate::where('id_user', '=', $user_id)->get();
        if(count($rates) > 0){
            foreach($rates as $rate){
                $books->push(book::find($rate->id_book));
            }
        }
        //return view('dashboard')->with('rates',$rates);
        return view('dashboard')->with('books',$books);*/
        return view('dashboard');
        
    }
}
