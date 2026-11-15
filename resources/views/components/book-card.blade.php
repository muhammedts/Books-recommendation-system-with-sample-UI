@props(['book'])

<div class="card h-100 shadow-sm book-card">
    <a href="{{ route('books.show', $book) }}" class="book-cover-link">
        <img src="{{ $book->cover_url }}" class="card-img-top book-cover" alt="Cover of {{ $book->title }}" loading="lazy">
    </a>
    <div class="card-body">
        <h3 class="h6 card-title mb-1">
            <a href="{{ route('books.show', $book) }}" class="stretched-link text-decoration-none">{{ $book->title }}</a>
        </h3>
        <p class="card-text small text-body-secondary mb-0">
            {{ $book->authors }}
            @if ($book->original_publication_year)
                <br>{{ $book->original_publication_year }}
            @endif
        </p>
    </div>
    <div class="card-footer bg-transparent small">
        <x-stars :value="$book->average_rating" />
        <span class="text-body-secondary ms-1">{{ number_format((float) $book->average_rating, 2) }}</span>
    </div>
</div>
