<!-- Modal -->
@if(!Auth::guest())

<div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="background: black">
                    <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Rate {{$book->title}}</h4>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <div>Please rate..</div>

                        {!! Form::open(['action' =>['booksController@rate' ,$book->id], 'method' =>'POST']) !!}

                        {{Form::label('rate5','-')}}
                        {{form::radio('rating','5',false)}}
                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                        </span><span class="fas fa-star"></span><span class="fas fa-star">
                        </span><span class="fas fa-star"></span><br>

                        {{Form::label('rate4','-')}}
                        {{form::radio('rating','4',false)}}
                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                        </span><span class="fas fa-star"></span><span class="fas fa-star">
                        </span><span class="far fa-star"></span><br>

                        {{Form::label('rate3','-')}}
                        {{form::radio('rating','3',false)}}
                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                        </span><span class="fas fa-star"></span><span class="far fa-star">
                        </span><span class="far fa-star"></span><br>

                        {{Form::label('rate2','-')}}
                        {{form::radio('rating','2',false)}}
                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                        </span><span class="far fa-star"></span><span class="far fa-star">
                        </span><span class="far fa-star"></span><br>

                        {{Form::label('rate1','-')}}
                        {{form::radio('rating','1',false)}}
                        <span class="fas fa-star"></span><span class="far fa-star"></i>
                        </span><span class="far fa-star"></span><span class="far fa-star">
                        </span><span class="far fa-star"></span><br>


                        {{ Form::hidden('user_id', Auth::user()->id ) }}
                        {{ Form::hidden('book_id', $book->id) }}


                        {{Form::submit('Rate' ,['class' => 'btn btn-primary'])}}

                        {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>
        <!--raaaaaaaaaaaaaaate-->
@endif
