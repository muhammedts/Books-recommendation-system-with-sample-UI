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
        $rates = User::find($user_id)->rates()->get();


        //recommendation section-------------------------
        $recommendations = recommendation::find($user_id);
        //dd($recommendations);

        if( $recommendations != null){
            $recArr['rec1'] = book::find($recommendations->recommendation1);
            $recArr['rec2'] = book::find($recommendations->recommendation2);
            $recArr['rec3'] = book::find($recommendations->recommendation3);
            $recArr['rec4'] = book::find($recommendations->recommendation4);
            $recArr['rec5'] = book::find($recommendations->recommendation5);
            $recArr['rec6'] = book::find($recommendations->recommendation6);
            $recArr['rec7'] = book::find($recommendations->recommendation7);
            $recArr['rec8'] = book::find($recommendations->recommendation8);
            $recArr['rec9'] = book::find($recommendations->recommendation9);
            $recArr['rec10'] = book::find($recommendations->recommendation10);
        }
        else{
            $recArr = null;
        }
        //dd($recommendations);



        return view('dashboard',compact('rates', 'recArr'));
    }
}
