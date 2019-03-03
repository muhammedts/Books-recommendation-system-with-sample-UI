@extends('layouts.app')
@section('content')
    <div class="row">

            <div class="col-lg-3">
      
              <h1 class="my-4">Shop Name</h1>
              <div class="list-group">
                <a href="#" class="list-group-item">Category 1</a>
                <a href="#" class="list-group-item">Category 2</a>
                <a href="#" class="list-group-item">Category 3</a>
              </div>
      
            </div>
            <!-- /.col-lg-3 -->
      
            <div class="col-lg-9">
      
              <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img class="d-block img-fluid" src="{{ asset('images/slider1.jpg') }}" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block img-fluid" src="{{ asset('images/slider2.jpg') }}" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block img-fluid" src="{{ asset('images/slider3.jpg') }}" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
              <div class="row">
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

          
                @endif
      
              </div>
              <br>
              <!-- /.row -->
              {{$books->links()}}
            </div>
            <!-- /.col-lg-9 -->
      
          </div>
          <!-- /.row -->
          
@endsection