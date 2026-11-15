<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        $book = $this->route('book');

        return $book instanceof Book
            ? $this->user()->can('update', $book)
            : $this->user()->can('create', Book::class);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:500'],
            'authors' => ['required', 'string', 'max:1000'],
            'isbn' => ['nullable', 'string', 'max:20', 'regex:/^[0-9Xx-]+$/'],
            'original_publication_year' => ['nullable', 'integer', 'between:-3000,'.(now()->year + 1)],
            'language_code' => ['nullable', 'string', 'max:16'],
            'image_url' => ['nullable', 'url:http,https', 'max:255'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'original_publication_year' => 'publication year',
            'image_url' => 'cover URL',
            'cover' => 'cover image',
        ];
    }
}
