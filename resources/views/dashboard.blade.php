@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

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
        <br>
        <br>
        <br>  <br>
        <br>
        <div class="col-md-8">
        <div class="card">
                <div class="card-header">Books to read: </div>
                <br>
                <br>  <br>
                <br>
                </div>
        </div>
        <div class="col-md-8">
                <div class="card">
                        <div class="card-header">your books recommendations: </div>
                        <br>
                        <br><br>
                        <br>
                  </div>
          </div>
          <div class="col-md-8">
            <div class="card">
                    <div class="card-header">Rated books: </div>
                    <br>
                    <br> 
                    @if(!empty($rates))
                      <table class="table table-striped">
                        <tr>
                            <th>Book title</th>
                            <th>Auther</th>
                            <th>Avarave Rate</th>
                            <th>Your Rate</th>
                        </tr>
                        @foreach($rates as $rate)
                        <tr>
                            <td>{{optional($rate->book)->title}}</td>
                            <td>{{optional($rate->book)->authors}}</td>
                            <td>{{optional($rate->book)->average_rating}}</td><!--can not read culs of book-->
                            <td>{{$rate->user_rate}}</td>
                        </tr>
                        @endforeach
                        
                      </table> <br>
                    @else <h2>No Rates yet</h2>
                    @endif
                    <br>
                    </div>
            </div>
       </div>       
</div>
@endsection


