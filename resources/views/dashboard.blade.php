@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h2">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="float-left ">You are logged in!<p>
                    <a class="btn btn-danger float-right" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                     {{ __('Logout') }}
                 </a>
                </div>

            </div>
        </div>
        <br>
        <div class="col-md-8">
                <div class="card">
                    <div class="card-header h2">your books recommendations: </div>
                        @if(!empty($recArr))
                            <table class="table table-striped">
                                <tr>
                                    <th>Book title</th>
                                    <th>Auther</th>
                                    <th>Avarage Rate</th>
                                </tr>
                                @foreach($recArr as $rec)
                                <tr>
                                    <td> <a href="/books/{{$rec->id}}">{{$rec->title}}</a> </td>
                                    <td>{{$rec->authors}}</td>
                                    <td>{{$rec->average_rating}}</td>
                                </tr> 
                                @endforeach
                            </table> <br>
                    @else <h2>your have no recommendations yet!</h2>
                    @endif
                  </div>
          </div>
          <br>
          <div class="col-md-8">
            <div class="card">
                    <div class="card-header h2">Rated books: </div>
                        @if(!empty($rates))
                        <table class="table table-striped">
                            <tr>
                                <th>Book title</th>
                                <th>Auther</th>
                                <th>Avarage Rate</th>
                                <th>Your Rate</th>
                            </tr>
                            @foreach($rates as $rate)
                                <tr>
                                    <td> <a href="/books/{{$rate->book->id}}">{{$rate->book->title}}</a> </td>
                                    <td>{{$rate->book->authors}}</td>
                                    <td>{{$rate->book->average_rating}}</td>
                                    <td>{{$rate->rating}}</td>
                            </tr>
                            @endforeach
                        </table>
                    @else <h2>No Rates yet</h2>
                    @endif
                    </div>
            </div>
       </div>       
</div>
@endsection


