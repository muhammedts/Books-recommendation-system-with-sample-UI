@extends('layouts.app')
@section('content')







<div class="row">
        <div class="col-lg-3">
          <h1 class="mb-4">Shop Name</h1>
          <div class="list-group">
            <a href="#" class="list-group-item active">Category 1</a>
            <a href="#" class="list-group-item">Category 2</a>
            <a href="#" class="list-group-item">Category 3</a>
          </div>
        </div>
        <!-- /.col-lg-3 -->
  
        <div class="col-lg-9">
  <!--
          <label for="one_star"><span class="fas fa-star"></span></label>
          <input type="radio" id="one_star">

          <label for="two_star"><span class="fas fa-star"></span><span class="fas fa-star"></span></label>
          <input type="radio" id="two_star">
  -->
          <div class="book row">
            <div class="col-sm-2">
                <img class="mx-auto" src={{$book->image_url}} alt="">
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
                              <h1 class="rating-num">
                                  4.0</h1>
                              <div class="rating">
                                  <span class="fas fa-star"></span><span class="fas fa-star"></i>
                                  </span><span class="fas fa-star"></span><span class="fas fa-star">
                                  </span><span class="far fa-star"></span>
                              </div>
                              <div>
                                  <span class="fas fa-star"></span>1,050,008 total
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-6">
                              <div class="row rating-desc">
                                  <div class="col-xs-3 col-md-3 text-right">
                                      <span class="fas fa-star"></span>5
                                  </div>
                                  <div class="col-xs-8 col-md-9">
                                      <div class="progress">
                                          <div class="progress-bar bg-success" role="progressbar" aria-valuenow="20"
                                              aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                              <span class="sr-only">80%</span>
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
                                              aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                              <span class="sr-only">60%</span>
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
                                              aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                              <span class="sr-only">40%</span>
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
                                              aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                              <span class="sr-only">20%</span>
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
                                              aria-valuemin="0" aria-valuemax="100" style="width: 15%">
                                              <span class="sr-only">15%</span>
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


  
          <div class="card card-outline-secondary my-4">
            <div class="card-header">
              Product Reviews
            </div>
            <div class="card-body">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
              <small class="text-muted">Posted by Anonymous on 3/1/17</small>
              <hr>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
              <small class="text-muted">Posted by Anonymous on 3/1/17</small>
              <hr>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
              <small class="text-muted">Posted by Anonymous on 3/1/17</small>
              <hr>
              <a href="#" class="btn btn-success">Leave a Review</a>
            </div>
          </div>
          <!-- /.card -->
  
        </div>
        <!-- /.col-lg-9 -->
  
      </div>
  
@endsection