<!-- Modal -->
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
                    
                        {!! Form::open(['action' =>['booksController@rate' ,$book->book_id], 'method' =>'POST']) !!}
                        
                        {{Form::label('rate5','-')}}    
                        {{form::radio('user_rate','5',false)}}
                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                        </span><span class="fas fa-star"></span><span class="fas fa-star">
                        </span><span class="fas fa-star"></span><br>

                        {{Form::label('rate4','-')}}    
                        {{form::radio('user_rate','4',false)}}
                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                        </span><span class="fas fa-star"></span><span class="fas fa-star">
                        </span><span class="far fa-star"></span><br>
                            
                        {{Form::label('rate3','-')}}
                        {{form::radio('user_rate','3',false)}}
                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                        </span><span class="fas fa-star"></span><span class="far fa-star">
                        </span><span class="far fa-star"></span><br>
                            
                        {{Form::label('rate2','-')}}
                        {{form::radio('user_rate','2',false)}}
                        <span class="fas fa-star"></span><span class="fas fa-star"></i>
                        </span><span class="far fa-star"></span><span class="far fa-star">
                        </span><span class="far fa-star"></span><br>
                            
                        {{Form::label('rate1','-')}}
                        {{form::radio('user_rate','1',false)}}
                        <span class="fas fa-star"></span><span class="far fa-star"></i>
                        </span><span class="far fa-star"></span><span class="far fa-star">
                        </span><span class="far fa-star"></span><br>


                        {{ Form::hidden('id_user', Auth::user()->id ) }}
                        {{ Form::hidden('id_book', $book->book_id) }}
                        
                        
                        {{Form::submit('Rate' ,['class' => 'btn btn-primary'])}}

                        {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>
        <!--raaaaaaaaaaaaaaate-->
        