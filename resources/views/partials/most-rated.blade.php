<h2 class="h5 mb-3">Most rated books</h2>

@if ($mostRated->isEmpty())
    <p class="text-body-secondary small">No ratings yet. Be the first to rate a book!</p>
@else
    <div class="list-group mb-4">
        @foreach ($mostRated as $popular)
            <a href="{{ route('books.show', $popular) }}"
               class="list-group-item list-group-item-action d-flex justify-content-between align-items-start gap-2">
                <span class="text-truncate">{{ $popular->title }}</span>
                <span class="badge text-bg-primary rounded-pill" title="{{ $popular->ratings_count }} ratings">
                    {{ number_format($popular->ratings_count) }}
                </span>
            </a>
        @endforeach
    </div>
@endif
