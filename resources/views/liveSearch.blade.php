@extends('layouts.app')
@section('content')

              <!--added new-->
<div class="form-group">
  {!! Form::open(['action' =>['LiveSearchController@indexForm'], 'method' =>'post']) !!}
  {{ Form::text('query', '' , ['class' => 'form-control' , 'placeholder' => 'Search...'])}}
  {{ Form::submit('Search' ,['class' => 'btn btn-primary'])}}
  {!! Form::close() !!}
</div>

{{-- <div class="table-responsive">
  <h3 alig="center">Total Data : <span id="total_records"></span></h3>           
</div> --}}

<div class="row">
      @if(isset($books))
      @foreach ($books as $book) 
      <div class="col-lg-2 col-md-2">
        <div class="card h-100">
          <a href="/books/{{$book->id}}"><img class="card-img-top" src={{ asset($book->image_url) }} alt="img"></a>
          <div class="card-body">
            <h5 class="card-title">
              <a href="/books/{{$book->id}}">{{$book->title}}</a>
            </h5>
            
            <p class="card-text">{{$book->original_publication_year}}<br>{{$book->authors}}<br>{{$book->language_code}}</p>  
          </div>
          <div class="card-footer">
          <small class="text-muted">Rating:.{{$book->average_rating}}</small>
          </div>
        </div>
      </div>
      @endforeach
      @else <h5 class="card-title">No Books Found</h5>
      @endif
</div>
    {{$books->links()}}
@endsection
