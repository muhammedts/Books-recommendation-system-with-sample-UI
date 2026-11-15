<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Browse and search the catalogue (?q= filters on title or author).
     */
    public function index(Request $request): View
    {
        $query = trim($request->string('q')->toString());

        $books = Book::query()
            ->search($query)
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        $mostRated = Book::query()
            ->where('ratings_count', '>', 0)
            ->mostRated()
            ->limit(5)
            ->get(['id', 'title', 'ratings_count', 'average_rating']);

        return view('books.index', [
            'books' => $books,
            'query' => $query,
            'mostRated' => $mostRated,
        ]);
    }

    public function show(Request $request, Book $book): View
    {
        $book->load(['reviews' => fn ($query) => $query->with('user:id,name')->latest()]);

        $userRating = $request->user()
            ? $book->ratings()->where('user_id', $request->user()->id)->value('rating')
            : null;

        return view('books.show', [
            'book' => $book,
            'breakdown' => $book->ratingBreakdown(),
            'userRating' => $userRating,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Book::class);

        return view('books.create', ['book' => new Book]);
    }

    public function store(BookRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('cover');

        if ($request->hasFile('cover')) {
            $data['image_url'] = $request->file('cover')->store('covers', 'public');
        }

        $book = Book::create($data);

        return to_route('books.show', $book)->with('success', 'Book created.');
    }

    public function edit(Book $book): View
    {
        Gate::authorize('update', $book);

        return view('books.edit', ['book' => $book]);
    }

    public function update(BookRequest $request, Book $book): RedirectResponse
    {
        $data = $request->safe()->except(['cover', 'image_url']);

        if ($request->hasFile('cover')) {
            $data['image_url'] = $request->file('cover')->store('covers', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image_url'] = $request->validated('image_url');
        }

        if (isset($data['image_url']) && $data['image_url'] !== $book->image_url) {
            $this->deleteUploadedCover($book);
        }

        $book->update($data);

        return to_route('books.show', $book)->with('success', 'Book updated.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        Gate::authorize('delete', $book);

        $this->deleteUploadedCover($book);
        $book->delete();

        return to_route('books.index')->with('success', 'Book deleted.');
    }

    private function deleteUploadedCover(Book $book): void
    {
        if ($book->hasUploadedCover()) {
            Storage::disk('public')->delete($book->image_url);
        }
    }
}
