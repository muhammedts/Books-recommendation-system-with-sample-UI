@extends('layouts.app', ['title' => $query !== '' ? 'Search: '.$query : 'Books'])

@section('content')
    <div class="row g-4">
        <aside class="col-lg-3 order-lg-1 order-2">
            @include('partials.most-rated')
        </aside>

        <div class="col-lg-9 order-lg-2 order-1">
            @if ($query === '' && $books->onFirstPage())
                <div id="readitCarousel" class="carousel slide mb-4 rounded overflow-hidden shadow-sm" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ([1, 2, 3] as $i)
                            <button type="button" data-bs-target="#readitCarousel" data-bs-slide-to="{{ $i - 1 }}"
                                    @if ($i === 1) class="active" aria-current="true" @endif aria-label="Slide {{ $i }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ([1, 2, 3] as $i)
                            <div @class(['carousel-item', 'active' => $i === 1])>
                                <img src="{{ asset("images/slider{$i}.jpg") }}" class="d-block w-100 carousel-img" alt="">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#readitCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#readitCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('books.index') }}" method="GET" class="mb-4" role="search" data-live-search="#search-results">
                <div class="input-group input-group-lg">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="search" name="q" value="{{ $query }}" class="form-control"
                           placeholder="Search by title or author" aria-label="Search by title or author" autocomplete="off">
                    <button class="btn btn-dark" type="submit">Search</button>
                </div>
            </form>

            <div id="search-results">
                <div class="d-flex justify-content-between align-items-baseline mb-3">
                    <h1 class="h4 mb-0">
                        @if ($query !== '')
                            Results for &ldquo;{{ $query }}&rdquo;
                        @else
                            All books
                        @endif
                    </h1>
                    <span class="text-body-secondary small">{{ number_format($books->total()) }} {{ Str::plural('book', $books->total()) }}</span>
                </div>

                @if ($books->isEmpty())
                    <div class="text-center text-body-secondary py-5">
                        <i class="bi bi-journal-x display-5 d-block mb-2"></i>
                        No books found{{ $query !== '' ? ' for "'.$query.'"' : '' }}.
                    </div>
                @else
                    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3">
                        @foreach ($books as $book)
                            <div class="col">
                                <x-book-card :book="$book" />
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
