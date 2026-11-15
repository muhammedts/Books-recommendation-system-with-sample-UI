@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="d-flex justify-content-between align-items-baseline mb-4">
        <h1 class="h3 mb-0">Hi, {{ auth()->user()->name }}</h1>
        <a href="{{ route('books.index') }}" class="btn btn-outline-dark btn-sm"><i class="bi bi-search"></i> Find books to rate</a>
    </div>

    <section class="card shadow-sm mb-4">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-baseline">
            <h2 class="h5 mb-0">Recommended for you</h2>
            @if ($generatedAt)
                <span class="text-body-secondary small">Updated {{ $generatedAt->diffForHumans() }}</span>
            @endif
        </div>

        @if ($recommendations->isEmpty())
            <div class="card-body text-center py-5" data-testid="recommendations-empty">
                <i class="bi bi-stars display-6 text-warning d-block mb-2"></i>
                <p class="fw-semibold mb-1">No recommendations yet.</p>
                <p class="text-body-secondary mb-0 mx-auto" style="max-width: 36rem">
                    Recommendations are generated in the background by a Spark ALS job that learns from everyone's
                    ratings. Rate a few books you know, and your personal picks will appear here after its next run.
                </p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center" style="width: 3rem">#</th>
                            <th scope="col">Book</th>
                            <th scope="col" class="d-none d-md-table-cell">Author</th>
                            <th scope="col">Average</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recommendations as $recommendation)
                            <tr>
                                <td class="text-center text-body-secondary">{{ $recommendation->rank }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $recommendation->book->cover_url }}" alt="" class="rounded book-thumb">
                                        <a href="{{ route('books.show', $recommendation->book) }}">{{ $recommendation->book->title }}</a>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">{{ $recommendation->book->authors }}</td>
                                <td class="text-nowrap">
                                    <x-stars :value="$recommendation->book->average_rating" />
                                    <span class="small text-body-secondary">{{ number_format((float) $recommendation->book->average_rating, 2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    <section class="card shadow-sm">
        <div class="card-header bg-transparent">
            <h2 class="h5 mb-0">Your ratings <span class="text-body-secondary">({{ $ratings->total() }})</span></h2>
        </div>

        @if ($ratings->isEmpty())
            <div class="card-body text-body-secondary">
                You haven't rated any books yet. <a href="{{ route('books.index') }}">Browse the catalogue</a> to get started.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Book</th>
                            <th scope="col" class="d-none d-md-table-cell">Author</th>
                            <th scope="col">Average</th>
                            <th scope="col">Your rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ratings as $rating)
                            <tr>
                                <td><a href="{{ route('books.show', $rating->book) }}">{{ $rating->book->title }}</a></td>
                                <td class="d-none d-md-table-cell">{{ $rating->book->authors }}</td>
                                <td>{{ number_format((float) $rating->book->average_rating, 2) }}</td>
                                <td><x-stars :value="$rating->rating" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($ratings->hasPages())
                <div class="card-footer bg-transparent">{{ $ratings->links() }}</div>
            @endif
        @endif
    </section>
@endsection
