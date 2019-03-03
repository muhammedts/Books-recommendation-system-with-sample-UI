<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LiveSearch extends Controller
{
    function index()
    {
     return view('liveSearch');
    }
    
    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('books')
         ->where('title', 'like', '%'.$query.'%')
         ->orWhere('authors', 'like', '%'.$query.'%')
         ->get();  
      }
      else
      {
       $data = DB::table('books')
         ->orderBy('book_id', 'desc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <div class="row">
      
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src=".$row->image_url." alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#">.$row->title.</a>
                </h4>
                <h5>new</h5>
                <p class="card-text">for .$row->authors.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>
        ';
       }
      }
      else
      {
       $output = '
        <h2 align="center" colspan="5">No Data Found</h2>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
}
?>