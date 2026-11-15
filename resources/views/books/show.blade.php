@extends('layouts.app', ['title' => $book->title])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Books</a></li>
            <li class="breadcrumb-item active text-truncate" aria-current="page">{{ $book->title }}</li>
        </ol>
    </nav>

    <div class="row g-4 mb-4">
        <div class="col-sm-4 col-md-3">
            <img src="{{ $book->cover_url }}" class="img-fluid rounded shadow-sm w-100 book-cover-lg" alt="Cover of {{ $book->title }}">
        </div>

        <div class="col-sm-8 col-md-9">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <h1 class="h2 mb-1">{{ $book->title }}</h1>

                @canany(['update', 'delete'], $book)
                    <div class="d-flex gap-2 flex-shrink-0">
                        @can('update', $book)
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-outline-dark btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        @endcan
                        @can('delete', $book)
                            <form action="{{ route('books.destroy', $book) }}" method="POST"
                                  onsubmit="return confirm('Delete this book and all its ratings and reviews?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                @endcanany
            </div>

            <p class="lead mb-3">{{ $book->authors }}</p>

            <dl class="row small mb-4">
                @if ($book->original_publication_year)
                    <dt class="col-sm-3 col-lg-2">Published</dt>
                    <dd class="col-sm-9 col-lg-10">{{ $book->original_publication_year }}</dd>
                @endif
                @if ($book->isbn)
                    <dt class="col-sm-3 col-lg-2">ISBN</dt>
                    <dd class="col-sm-9 col-lg-10">{{ $book->isbn }}</dd>
                @endif
                @if ($book->language_code)
                    <dt class="col-sm-3 col-lg-2">Language</dt>
                    <dd class="col-sm-9 col-lg-10">{{ $book->language_code }}</dd>
                @endif
            </dl>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center g-4">
                        <div class="col-md-4 text-center">
                            <div class="rating-num">{{ number_format((float) $book->average_rating, 2) }}</div>
                            <x-stars :value="$book->average_rating" class="fs-5" />
                            <div class="text-body-secondary small mt-1">
                                {{ number_format($book->ratings_count) }} {{ Str::plural('rating', $book->ratings_count) }}
                            </div>
                        </div>

                        <div class="col-md-8">
                            @php $total = max(1, array_sum($breakdown)); @endphp
                            @foreach ($breakdown as $stars => $count)
                                <div class="d-flex align-items-center gap-2 mb-1 small">
                                    <span class="text-nowrap" style="width: 2.5rem">{{ $stars }} <i class="bi bi-star-fill text-warning"></i></span>
                                    <div class="progress flex-grow-1" role="progressbar" aria-label="{{ $stars }} star ratings"
                                         aria-valuenow="{{ $count }}" aria-valuemin="0" aria-valuemax="{{ $total }}">
                                        <div @class([
                                            'progress-bar',
                                            'bg-success' => $stars >= 4,
                                            'bg-info' => $stars === 3,
                                            'bg-warning' => $stars === 2,
                                            'bg-danger' => $stars === 1,
                                        ]) style="width: {{ round($count / $total * 100, 1) }}%"></div>
                                    </div>
                                    <span class="text-body-secondary text-end" style="width: 3rem">{{ number_format($count) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-transparent">
                    @auth
                        <form action="{{ route('books.rating.store', $book) }}" method="POST" class="d-flex flex-wrap align-items-center gap-3">
                            @csrf
                            <span class="fw-semibold">{{ $userRating ? 'Your rating' : 'Rate this book' }}</span>
                            <div class="star-input" role="radiogroup" aria-label="Your rating">
                                @foreach ([5, 4, 3, 2, 1] as $stars)
                                    <input type="radio" class="btn-check" name="rating" id="rating-{{ $stars }}" value="{{ $stars }}"
                                           @checked((int) old('rating', $userRating) === $stars) required>
                                    <label for="rating-{{ $stars }}" title="{{ $stars }} {{ Str::plural('star', $stars) }}">
                                        <i class="bi bi-star-fill"></i>
                                    </label>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-dark btn-sm">{{ $userRating ? 'Update rating' : 'Rate' }}</button>
                            @error('rating')<span class="text-danger small">{{ $message }}</span>@enderror
                        </form>
                    @else
                        <span class="text-body-secondary small">
                            <a href="{{ route('login') }}">Log in</a> to rate and review this book.
                        </span>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <section class="card shadow-sm">
        <div class="card-header bg-transparent">
            <h2 class="h5 mb-0">Reviews <span class="text-body-secondary">({{ $book->reviews->count() }})</span></h2>
        </div>

        <div class="card-body">
            @forelse ($book->reviews as $review)
                <article @class(['pb-3 mb-3', 'border-bottom' => ! $loop->last])>
                    <div class="d-flex justify-content-between small text-body-secondary mb-1">
                        <strong class="text-body">{{ $review->user->name }}</strong>
                        <time datetime="{{ $review->created_at->toIso8601String() }}">{{ $review->created_at->diffForHumans() }}</time>
                    </div>
                    <p class="mb-0 review-body">{{ $review->body }}</p>
                </article>
            @empty
                <p class="text-body-secondary mb-0">This book has no reviews yet.@auth Write the first one!@endauth</p>
            @endforelse
        </div>

        @auth
            <div class="card-footer bg-transparent">
                <form action="{{ route('books.reviews.store', $book) }}" method="POST">
                    @csrf
                    <label for="body" class="form-label fw-semibold">Write a review</label>
                    <textarea name="body" id="body" rows="3" maxlength="5000"
                              class="form-control @error('body') is-invalid @enderror"
                              placeholder="What did you think of it?" required>{{ old('body') }}</textarea>
                    @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <button type="submit" class="btn btn-primary mt-2">Post review</button>
                </form>
            </div>
        @endauth
    </section>
@endsection
