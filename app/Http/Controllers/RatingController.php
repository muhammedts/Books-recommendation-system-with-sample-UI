<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateBookRequest;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;

class RatingController extends Controller
{
    public function store(RateBookRequest $request, Book $book): RedirectResponse
    {
        $book->rateBy($request->user(), $request->integer('rating'));

        return to_route('books.show', $book)->with('success', 'Your rating has been saved.');
    }
}
