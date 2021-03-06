@extends('layouts.app')
@section('content')

<div class="row">
        {{-- <div class="col-lg-3">
                @include('inc.mostrated')
        </div> --}}
        
        <!-- /.col-lg-3 -->
  
        <div class="col-lg-12">
  <!--
          <label for="one_star"><span class="fas fa-star"></span></label>
          <input type="radio" id="one_star">

          <label for="two_star"><span class="fas fa-star"></span><span class="fas fa-star"></span></label>
          <input type="radio" id="two_star">
  -->
  <div class="book row">
        <div class="col-sm-2">
             <img class="mx-auto" src="{{$book->image_url}}" alt="">
        </div>
        <div class="col-sm-10">
          <h1 class="book-title">{{$book->title}}</h3>
          <ul class="book-info list-unstyled">
            <li><strong>Author: </strong> {{$book->authors}}</li>
          <li><strong>Year: </strong>{{$book->original_publication_year}}</li>
          </ul>
        </div>
            
      </div>     
          <!-- /.card -->


          <!-- Rating -->
          <div class="row">
              <div class="col">
                  <div class="well well-sm">
                      <div class="row">
                          <div class="col-xs-12 col-md-6 text-center">
                              <h1 class="rating-num">{{$book->average_rating}}</h1>
                              <div class="rating">
                                    @if( $book->average_rating > 4.0 )
                                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                                        </span><span class="fas fa-star"></span><span class="fas fa-star">
                                        </span><span class="fas fa-star"></span>
                                    @elseif( $book->average_rating > 3.0 || $book->average_rating <= 4.0 )
                                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                                        </span><span class="fas fa-star"></span><span class="fas fa-star">
                                        </span><span class="far fa-star"></span>
                                    @elseif( $book->average_rating > 2.0 || $book->average_rating <= 3.0)
                                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                                        </span><span class="fas fa-star"></span><span class="far fa-star">
                                        </span><span class="far fa-star"></span>
                                    @elseif( $book->average_rating > 1.0 || $book->average_rating <= 2.0)
                                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                                        </span><span class="far fa-star"></span><span class="far fa-star">
                                        </span><span class="far fa-star"></span>
                                    @elseif( $book->average_rating >= 0.0 || $book->average_rating <= 1.0)
                                        <span class="far fa-star"></span><span class="far fa-star"></i>
                                        </span><span class="far fa-star"></span><span class="far fa-star">
                                        </span><span class="far fa-star"></span>
                                    @endif
                              </div>
                              <div>
                                  <span class="fas fa-star"></span>{{$book->work_ratings_count}} rate
                              </div>
                          </div>
                            
                          <div class="col-xs-12 col-md-6">
                              <div class="row rating-desc">
                                  <div class="col-xs-3 col-md-3 text-right">
                                      <span class="fas fa-star"></span>5
                                  </div>
                                  <div class="col-xs-8 col-md-9">
                                      <div class="progress">
                                            @php
                                            if($book->work_ratings_count == 0) { $totalRates = $book->work_ratings_count + 1 ;}
                                            else { $totalRates = $book->work_ratings_count ;}
                                            $percentage_5 = ($book->ratings_5 / $totalRates )*100;
                                            $percentage_4 = ($book->ratings_4 / $totalRates )*100;
                                            $percentage_3 = ($book->ratings_3 / $totalRates )*100;
                                            $percentage_2 = ($book->ratings_2 / $totalRates )*100;
                                            $percentage_1 = ($book->ratings_1 / $totalRates )*100;
                                            @endphp
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="20"
                                              aria-valuemin="0" aria-valuemax="100" style="width:{{$percentage_5}}% ">
                                              <span class="sr-only">{{$percentage_5}}</span>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- end 5 -->
                                  <div class="col-xs-3 col-md-3 text-right">
                                      <span class="fas fa-star"></span>4
                                  </div>
                                  <div class="col-xs-8 col-md-9">
                                      <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="20"
                                              aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage_4}}% ">
                                              <span class="sr-only">{{$percentage_4}}</span>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- end 4 -->
                                  <div class="col-xs-3 col-md-3 text-right">
                                      <span class="fas fa-star"></span>3
                                  </div>
                                  <div class="col-xs-8 col-md-9">
                                      <div class="progress">
                                          <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20"
                                              aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage_3}}% ">
                                              <span class="sr-only">{{$percentage_3}}</span>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- end 3 -->
                                  <div class="col-xs-3 col-md-3 text-right">
                                      <span class="fas fa-star"></span>2
                                  </div>
                                  <div class="col-xs-8 col-md-9">
                                      <div class="progress">
                                          <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="20"
                                              aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage_2}}%">
                                              <span class="sr-only">{{$percentage_2}}</span>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- end 2 -->
                                  <div class="col-xs-3 col-md-3 text-right">
                                      <span class="fas fa-star"></span>1
                                  </div>
                                  <div class="col-xs-8 col-md-9">
                                      <div class="progress">
                                          <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="80"
                                              aria-valuemin="0" aria-valuemax="100" style="width:{{$percentage_1}}%">
                                              <span class="sr-only">{{$percentage_1}}</span>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- end 1 -->
                              </div>
                              <!-- end row -->
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <br>
          <!--raaaaaaaaaaaaaate-->
          <button type="submit"  class="rate_now btn btn-dark generalDonation" data-toggle="modal"  data-backdrop="static" data-keyboard="false" data-target="#myModalHorizontal">Rate Now</button>
          @include('books/rate')

          <br>
        
          @if(!Auth::guest())
          @if(Auth::user()->id==1)<!--me4 lazem 1 -->
        <a href="/books/{{$book->id}}/edit" class="btn btn-dark">Edit</a> 

        {!!Form::open(['action'=>['booksController@destroy',$book->id],'method'=>'POST','class'=>'float-right'])!!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
        {!!Form::close()!!}
          @endif
          @endif

          <div class="card card-outline-secondary my-4">
            <div class="card-header">
              Book Reviews
            </div>
            <div class="card-body">
              <!--if there is rewirw plz put it-->
              @if(isset($book->reviews))
                <table class="table table-striped">
                    <tr>
                        <th>User name</th>
                        <th>Review</th>
                    </tr>
                    @foreach($book->reviews as $Review)
                    <tr>
                        <td>{{$Review->user->name}}</td>
                        <td>{{$Review->review}}</td>
                    </tr> 
                    @endforeach
                </table> <br>
                @else <h2>This book have no reviews yet, write one now!</h2>
                @endif
            </div>
            <div class="card-body">
            {!!Form::open(['action'=>['reviewController@index'],'method'=>'POST' ])!!}
                <div class='form-group'>
                    {{Form::text('review' , '' , ['class' => 'form-control ','placeholder' => 'write your opinion..'])}}
                </div>
               
                {{ Form::hidden('user_id', Auth::user()->id ) }}
                {{ Form::hidden('book_id', $book->id) }}
                {{Form::submit('Add Review',['class'=>'btn btn-primary'])}}
            {{Form::close()}}
            </div>
        </div>
          <!-- /.card -->
  
        </div>
        <!-- /.col-lg-9 -->
  
      </div>
 
@endsection
