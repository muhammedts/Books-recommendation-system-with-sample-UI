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
                </div>
        </div>
        <div class="col-md-8">
                <div class="card">
                        <div class="card-header">The Book you have rated before: </div>
                        <br>
                        <!--<br><div class="row">
                            @if(count($books)>0)
                            @foreach ($books as $book)
                            <div class="col-lg-3 col-md-3">
                              <div class="card h-100">
                                <a href="/books/{{$book->book_id}}"><img class="card-img-top" src={{$book->image_url}} alt="img"></a>
                                <div class="card-body">
                                  <h5 class="card-title">
                                    <a href="/books/{{$book->book_id}}">{{$book->title}}</a>
                                  </h5>
                                  
                                  <p class="card-text">{{$book->original_publication_year}}<br>{{$book->authors}}<br>{{$book->language_code}}</p>  
                                </div>
                                <div class="card-footer">
                                <small class="text-muted">Rating:.{{$book->average_rating}}</small>
                                </div>
                              </div>
                            </div>
                            @endforeach
                            @else 
                            <h2>there is nothing</h2>
                            @endif
                                
                        
                             </div><br>-->
                        <br>
                        </div>
                </div>
                </div>
        </div>
        
</div>
@endsection
