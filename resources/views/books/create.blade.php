@extends('layouts.app')
@section('content')
    <h1>Add Book</h1>

{!! Form::open(['action' => 'booksController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title','Title')}}
        {{Form::text('title','',['class'=>'form-control','placeholder'=>'Title'])}}
    </div>
    <div class="form-group">
        {{Form::label('isbn','ISBN')}}
        {{Form::text('isbn','',['class'=>'form-control','placeholder'=>'ISBN'])}}
    </div>
    <div class="form-group">
            {{Form::label('authors','Authors')}}
            {{Form::text('authors','',['class'=>'form-control','placeholder'=>'Authors'])}}
        </div>
    <div class="form-group">
            {{Form::label('year','Year')}}
            {{Form::text('original_publication_year','',['class'=>'form-control','placeholder'=>'Year'])}}
        </div>
    <div class="form-group">
            {{Form::label('language code','Language')}}
            {{Form::text('language_code','',['class'=>'form-control','placeholder'=>'Language code'])}}
    </div>
    <div class="form-group">
            {{Form::label('Cover Image','Image')}}
            <br>
            {{Form::file('image_url')}}
    </div>
    {{Form::submit('submit',['class'=>'btn btn-primary'])}}
    </div>
       
        
{!! Form::close() !!}

@endsection
