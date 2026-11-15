@extends('layouts.app', ['title' => 'Add a book'])

@section('content')
    <div class="card shadow-sm mx-auto" style="max-width: 900px">
        <div class="card-body p-4">
            <h1 class="h3 mb-4">Add a book</h1>

            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                @include('books._form')

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Create book</button>
                    <a href="{{ route('books.index') }}" class="btn btn-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
