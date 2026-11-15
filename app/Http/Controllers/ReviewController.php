<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Book $book): RedirectResponse
    {
        $review = $book->reviews()->make($request->validated());
        $review->user()->associate($request->user());
        $review->save();

        return to_route('books.show', $book)->with('success', 'Thanks for your review!');
    }
}
