<?php

namespace App\Http\Controllers;
use App\book;
use Illuminate\Http\Request;
use DB;

class LiveSearchController extends Controller
{
    function index()
    {
      $books = book::orderBy('average_rating','desc')->paginate(8);

      return view('liveSearch')->with('books',$books);
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
     
            <div class="col-lg-2 col-sm-6 col-md-6 mb-4">
              <div class="card h-100">
                <a href="/books/'.$row->book_id.'"><img class="card-img-top" src="'.$row->image_url.'" alt=""></a>
                <div class="card-body">
                  <h4 class="card-title">
                    <a href="/books/'.$row->book_id.'">'.$row->title.'</a>
                  </h4>
                  <p class="card-text">for '.$row->authors.'</p>
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