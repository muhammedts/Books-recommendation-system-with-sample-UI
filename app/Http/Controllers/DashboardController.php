<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\book;
use App\rate;
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
    public function indexx()
    {
        $user_id = auth()->user()->id;
        $rates = rate::where('id_user', '=', $user_id )->get();

        if(!empty($rates)){
            foreach($rates as $rate){
                $books = ( book::find($rate->book_id) ); //->groupBy('title')
            }
        }
        else{ $books = null; }
        
        return view('dashboard')->with('books', $books);
        
    }
    public function index()
    {
        //$user_id = auth()->user()->id;
        $user = User::find('2');
        return view('dashboard')->with('rates', $user->rates);  
    }
}
