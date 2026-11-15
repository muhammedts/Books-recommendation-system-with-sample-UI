<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('rate', $this->route('book'));
    }

    /**
     * Only the rating itself is accepted: the user and the book come from
     * the session and the URL, never from the form.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'between:1,5'],
        ];
    }
}
