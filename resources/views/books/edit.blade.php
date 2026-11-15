@extends('layouts.app', ['title' => 'Edit '.$book->title])

@section('content')
    <div class="card shadow-sm mx-auto" style="max-width: 900px">
        <div class="card-body p-4">
            <h1 class="h3 mb-4">Edit &ldquo;{{ $book->title }}&rdquo;</h1>

            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('books._form')

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Save changes</button>
                    <a href="{{ route('books.show', $book) }}" class="btn btn-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
