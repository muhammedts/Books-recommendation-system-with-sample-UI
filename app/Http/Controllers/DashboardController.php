<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\book;
use App\Rate;
use App\User;
use App\recommendation;
use DB;
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
        $rates = User::find($user_id)->rates()->with('book')->get();

        //$recommendation = recommendation::where('userId',$user_id);
        $recommendation = DB::table('recommendations')
         ->where('userId', 'like', $user_id)
         ->get();

        //dd($recommendation);
        //var_dump($recommendation[0]->recommendation1);//yeeeeeeeees
        $books[0]= book::find($recommendation[0]->recommendation1);
        $books[1]= book::find($recommendation[0]->recommendation2);
        $books[2]= book::find($recommendation[0]->recommendation3);
        $books[3]= book::find($recommendation[0]->recommendation4);
        $books[4]= book::find($recommendation[0]->recommendation5);
        $books[5]= book::find($recommendation[0]->recommendation6);
        $books[6]= book::find($recommendation[0]->recommendation7);
        $books[7]= book::find($recommendation[0]->recommendation8);
        $books[8]= book::find($recommendation[0]->recommendation9);
        $books[9]= book::find($recommendation[0]->recommendation10);

        //dd($books);


        return view('dashboard',compact('rates' , 'books'));
    }
}
