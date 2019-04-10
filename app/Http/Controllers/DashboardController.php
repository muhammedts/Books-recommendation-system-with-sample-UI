<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\book;
use App\rate;
use App\User;
use App\recommendation;
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
        $recommendation = recommendation::where('userId','1');
        //dd($recommendation);


        return view('dashboard',compact('rates'));
    }
}
